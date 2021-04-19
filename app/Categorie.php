<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    //

    public function metiers(){
        return $this->belongsToMany('App\Metier');
    }
}
