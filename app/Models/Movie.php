<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function director() { 
        $this->belongsTo(Director::class);
    }
    public function actors(){
        $this->belongsToMany(Actor::class);
    }

}
