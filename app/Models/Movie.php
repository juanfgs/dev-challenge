<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\FilterableTrait;

class Movie extends Model
{
    use HasFactory;

    use FilterableTrait;

    public $fillable = ['director_id', 'genre', 'name', 'synopsis', 'pg_rating'];

    public $with = ['director', 'actors'];

    public static $filterable = ['name', 'release_date_from', 'release_date_to'];

    public function director() { 
        return $this->belongsTo(Director::class);
    }
    public function actors(){
        return $this->belongsToMany(Actor::class);
    }

    public function scopeName(Builder $query, string $name){
        return $query->where('name', 'like', "%" . $name . "%");
    }

    public function scopeReleaseDateFrom(Builder $query, string $date){
        return $query->where('release_date', '>', $date );
    }

    public function scopeReleaseDateTo(Builder $query, string $date){
        return $query->where('release_date', '<', $date );
    }



}
