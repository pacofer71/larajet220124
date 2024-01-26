<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public string $campo="id";
    public string $orden="desc";
    public string $search="";
   
    #[On('postCreado')]
    public function render()
    {
        $posts=Post::where('user_id', auth()->user()->id)
        ->where('titulo', 'like', "%".$this->search."%")
        ->orderBy($this->campo, $this->orden)
        ->paginate(5);
        return view('livewire.show-posts', compact('posts'));
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
   
}
