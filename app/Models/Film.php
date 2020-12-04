<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'key_name',
        'cover_image_name',
        'description',
    ];

}
