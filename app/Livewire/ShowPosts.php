<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPosts extends Component
{
    use WithPagination;
    
    public function render()
    {
        $posts=Post::where('user_id', auth()->user()->id)->paginate(5);
        return view('livewire.show-posts');
    }
}
