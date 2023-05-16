<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    public function movies(){
        $this->belongsToMany(Movie::class); 
    }
    public function episodes(){
        $this->belongsToMany(Episode::class); 
    }
    public function series(){
        $this->hasManyThrough(Series::class, Episode::class); 
    }
}
