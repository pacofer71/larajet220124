<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias=[
            'Informática'=>'Categoria relacionada con la informática',
            'Deportes'=>'Categoria relacionada con los deportes',
            'Cine'=>'Categoria relacionada con el cine',
            'Matemáticas'=>'Categoria relacionada con las matemáticas',
            'Literatura'=>'Categoria relacionada con la literatura',
            'Animales'=>'Categoria relacionada con los animales',
        ];
        foreach($categorias as $nombre=>$descripcion){
            Category::create(compact('nombre', 'descripcion'));
            //Category::create(['nombre'=>$nombre, 'descripcion'=>$descripcion]);
        }
    }
}
