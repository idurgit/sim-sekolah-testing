<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Book extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory, InteractsWithMedia;

    // add fillable
    protected $fillable = [
        'title',
        'author',
        'description',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }
}
