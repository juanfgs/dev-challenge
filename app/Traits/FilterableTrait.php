<?php

namespace App\Traits;

trait FilterableTrait {

    /*
     *
     * Filter by array params
     * param $filters
     * ['field' => 'value' ]
     *
     */


    public static function filter($filters){
        $query = self::select('*');
        foreach( $filters as $field => $value){
            $field = \Str::camel($field);
            $query = $query->$field($value);
        }
        return $query;
    }
}

