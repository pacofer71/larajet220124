<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;

    public string $campo="id";
    public string $orden="desc";
    public string $search="";
   
    
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
   
}
