<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    // public function registerMediaCollections(): void
    // {
    //     // 1 gambar cover
    //     $this->addMediaCollection('cover')
    //         ->singleFile();

    //     // banyak gambar isi artikel
    //     $this->addMediaCollection('content_images');
    // }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')
    //         ->width(400)
    //         ->height(250)
    //         ->sharpen(10)
    //         ->nonQueued()
    //         ->performOnCollections('cover');

    //     $this->addMediaConversion('content')
    //         ->width(800)
    //         ->sharpen(10)
    //         ->performOnCollections('content_images');
    // }
}
