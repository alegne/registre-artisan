<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metier extends Model
{
    //

    public function filiere(){
        return $this->belongsTo('App\Filiere');
    }

    public function categories(){
        return $this->belongsToMany('App\Categorie');
    }

    public function artisants(){
        return $this->belongsToMany('App\Artisant')->withPivot('primaire_ou_secondaire', 'dateDebut');
    }


    //mutateur
    public function setNameAttribute($value){
        return $this->attributes['name'] = ucfirst($value);
    }
}
