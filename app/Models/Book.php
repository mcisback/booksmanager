<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;

class Book extends Model
{
    use HasFactory;
    use Favoriteable;

    protected $fillable = [
        'name',
        'description',
        'cover',
        'price',
    ];
}
