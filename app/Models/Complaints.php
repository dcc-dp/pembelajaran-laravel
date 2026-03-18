<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $fillable = [
        'title',
        'description',
        'latitude',
        'longitude',
        'polygon',
        'geometry',
        'type'
    ];

    protected $casts = [
        'polygon' => 'array',
        'geometry' => 'array'
    ];

}
