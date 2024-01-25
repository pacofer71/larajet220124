<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CrearPost extends Component
{
    
    public bool $abrirModalCrear=true;

    public function render()
    {
        $categorias=Category::select('nombre', 'id')->orderBy('nombre')->get();
        return view('livewire.crear-post', compact('categorias'));
    }

   
}
