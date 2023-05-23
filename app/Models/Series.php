<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;

    public $with = ['actors'];

    public function actors(){
        return $this->belongsToMany(Actor::class);
    }

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

}
