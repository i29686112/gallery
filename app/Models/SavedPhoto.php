<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'upload_telegram_user_id',
        'film_id',
    ];
}
