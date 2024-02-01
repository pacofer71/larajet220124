<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactanosController;
use App\Http\Controllers\Socialite\GithubController;
use App\Livewire\ShowPosts;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $posts=Post::with('category', 'user')->where('estado', 'PUBLICADO')->paginate(5);
    return view('welcome', compact('posts'));
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    //Rutas con autenticacion
    Route::resource('categories', CategoryController::class)->except('show');

    Route::get('posts', ShowPosts::class)->name('posts.index');
    
});

Route::get('contactanos', [ContactanosController::class, 'pintarFormulario'])->name('contactanos.index');
Route::post('contactanos', [ContactanosController::class, 'procesarFormulario'])->name('contactanos.procesar');

//---------------------------Rutas para socilaite login 

Route::get('/auth/github/redirect', [GithubController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback', [GithubController::class, 'callback'])->name('github.callback');
/*
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
*/