<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostUpdateForm extends Form
{
    public $imagen;
    public ?Post $post;
    public string $titulo="";
    public string $contenido="";
    public string $category_id="";
    public string $estado="";

    public function setPost(Post $post){
        $this->post=$post;
        $this->titulo=$post->titulo;
        $this->contenido=$post->contenido;
        $this->estado=$post->estado;
        $this->category_id=$post->category_id;
    }

    public function rules(){
        return [
            'titulo'=>['required', 'string', 'min:3', 'unique:posts,titulo,'.$this->post->id],
            'contenido'=>['required', 'string', 'min:10'],
            'estado'=>['nullable'],
            'category_id'=>['required', 'exists:categories,id'],
            'imagen'=>['nullable', 'image', 'max:2048'],
        ];
    }

    public function updateBueno(){
        $this->validate();
        if($this->imagen && basename($this->post->imagen)!='noimage.png'){
            Storage::delete($this->post->imagen);
        }
        $ruta=($this->imagen) ? $this->imagen->store('posts') : $this->post->imagen;
        $this->post->update([
            'titulo'=>$this->titulo,
            'contenido'=>$this->contenido,
            'category_id'=>$this->category_id,
            'imagen'=>$ruta,
            'estado'=>($this->estado) ? "PUBLICADO" : "BORRADOR",
        ]);
    }
    public function cancelarBueno(){
        $this->reset(['post', 'titulo', 'contenido', 'imagen', 'estado', 'category_id']);
    }

    
}
