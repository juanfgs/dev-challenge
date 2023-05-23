<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    public $with = ['director','series'];
    
    public function director() { 
        return $this->belongsTo(Director::class);
    }

    public function series(){
        return $this->belongsTo(Series::class);
    }
}
