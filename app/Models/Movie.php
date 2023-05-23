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

    public $fillable = ['director_id', 'genre', 'title', 'synopsis', 'pg_rating','release_date'];

    public $with = ['director', 'actors'];

    public static $filterable = ['title', 'release_date_from', 'release_date_to', 'director'];
    public static $sortable = ['title', 'release_date', 'genre', 'pg_rating'];

    public function director() { 
        return $this->belongsTo(Director::class);
    }
    public function actors(){
        return $this->belongsToMany(Actor::class);
    }

    public function scopeTitle(Builder $query, string $title){
        return $query->where('title', 'like', "%" . $title . "%");
    }

    public function scopeReleaseDateFrom(Builder $query, string $date){
        return $query->where('release_date', '>', $date );
    }

    public function scopeReleaseDateTo(Builder $query, string $date){
        return $query->where('release_date', '<', $date );
    }

    public function scopeDirector(Builder $query, string $name){
        return $query->join('directors', 'directors.id','=','movies.director_id')
                     ->where('directors.name', '=', $name );
    }

}
