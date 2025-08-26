<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = ['name', 'phone'];
    
    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }
}
