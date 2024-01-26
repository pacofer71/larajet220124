<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearPost extends Component
{
    use WithFileUploads;

    public bool $abrirModalCrear=false;

    #[Validate(['nullable', 'image', 'max:2048'])]
    public $imagen;
    
    #[Validate(['required', 'string', 'min:3', 'unique:posts,titulo'])]
    public string $titulo="";

    #[Validate(['required', 'string', 'min:10'])]
    public string $contenido="";

    #[Validate(['nullable'])]
    public string $estado="";

    #[Validate(['required', 'exists:categories,id'])]
    public string $category_id="";

    public function render()
    {
        $categorias=Category::select('nombre', 'id')->orderBy('nombre')->get();
        return view('livewire.crear-post', compact('categorias'));
    }

    public function store(){
        $this->validate();
        Post::create([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'category_id'=>$this->category_id,
            'estado'=>($this->estado) ? "PUBLICADO" : "BORRADOR",
            'imagen'=>($this->imagen) ? $this->imagen->store('posts') : 'posts/noimage.png',
            'user_id'=>auth()->user()->id,
        ]);
        $this->dispatch('mensaje', "Post Creado");  //este evento se escucha en todos los sitios
        $this->dispatch('postCreado')->to(ShowPosts::class); //este va para una clase especifica que hay que indocar
        $this->cancelar();

    }
    public function cancelar(){
        $this->reset(['abrirModalCrear', 'titulo', 'contenido', 'category_id', 'estado', 'imagen']);
    }

   

   
}
