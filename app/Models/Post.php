<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    // add fillable
    protected $fillable = [
        'title',
        'content',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
