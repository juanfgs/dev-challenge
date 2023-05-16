<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    public function movies(){
        $this->hasMany(Movie::class);
    }
    public function episodes(){
        $this->hasMany(Episode::class);
    }
    public function series(){
        $this->hasManyThrough(Series::class,Episode::class);
    }
}
