<?php

namespace App\Livewire;

use App\Livewire\Forms\PostUpdateForm;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    use WithFileUploads;

    public string $campo="id";
    public string $orden="desc";
    public string $search="";

    //Variables para el update
    public bool $abrirModalUpdate=false;

    public PostUpdateForm $form;

   
    #[On('postCreado')]
    public function render()
    {
        $posts=Post::where('user_id', auth()->user()->id)
        ->where('titulo', 'like', "%".$this->search."%")
        ->orderBy($this->campo, $this->orden)
        ->paginate(5);
        
        $categorias=Category::select('id', 'nombre')->orderBy('nombre')->get();
        
        return view('livewire.show-posts', compact('posts', 'categorias'));
    }

    public function ordenar(string $campo){
        $this->orden=($this->orden=='asc') ? 'desc' : 'asc';
        $this->campo=$campo;
    }
    
    public function updatingSearch(){
        $this->resetPage();
    }

    public function pedirConfirmacion(Post $post){
        $this->authorize('delete', $post);
        $this->dispatch('confirmacionBorrar', $post->id);
    }

    #[On('borrarOk')]
    public function delete(Post $post){
        $this->authorize('delete', $post);
        
        if(basename($post->imagen!="noimage.png")){
            Storage::delete($post->imagen);
        }
        $post->delete();
        $this->dispatch("mensaje", "Post Eliminado.");
    }

    //Metods para actualizar registros----------------------
    public function edit(Post $post){
        //dd($post);
        $this->authorize('update', $post);
        $this->form->setPost($post);
        $this->abrirModalUpdate=true;
    }
    public function update(){
        $this->authorize('update', $this->form->post);
        $this->form->updateBueno();
        $this->limpiarCerrarUpdate();
        $this->dispatch("mensaje", "Post Editado");

    }

    public function limpiarCerrarUpdate(){
        $this->form->cancelarBueno();
        $this->abrirModalUpdate=false;
    }
   
}
