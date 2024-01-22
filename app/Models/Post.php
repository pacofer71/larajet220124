<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable=['titulo', 'contenido', 'estado', 'imagen', 'category_id', 'user_id'];

    //Relacion 1:n con User
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    //Relacion 1:n can Category
    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

    //Accesors y muttators
    public function titulo(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
    }
    public function contenido(): Attribute{
        return Attribute::make(
            set: fn($v)=>ucfirst($v),
        );
        
    }
}
