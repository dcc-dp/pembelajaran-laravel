<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['public_id', 'version', 'person_id'];
    
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
