<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    public function metiers(){
        return $this->hasMany('App\Metier');
    }

    /*
    public function artisants(){
        return $this->hasManyThrough('App\Artisant', 'App\Metier');
    }
    */
}
