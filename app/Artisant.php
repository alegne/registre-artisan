<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artisant extends Model
{

    public function region(){
        return $this->belongsTo('App\Region');
    }

    public function province(){
        return $this->hasOneThrough('App\Province', 'App\Region');
    }

    public function metiers(){
        return $this->belongsToMany('App\Metier')->withPivot('primaire_ou_secondaire', 'dateDebut');
    }

    //test
    public function filieres(){
        return $this->hasManyThrough(
            'App\Filiere',
            'App\ArtisantMetier',
            'artisant_id',
            'metier_id',
            'id',
            'metier_id',
        );
    }

    public function setNameAttribute($value){
        return $this->attributes['name'] = strtoupper($value);
    }

    public function setPrenomAttribute($value){
        return $this->attributes['prenom'] = ucwords($value);
    }

    public function setLieuNaissanceAttribute($value){
        return $this->attributes['lieuNaissance'] = ucfirst($value);
    }

    public function setAdresseAttribute($value){
        return $this->attributes['adresse'] = ucwords($value);
    }

    public function setCartierAttribute($value){
        return $this->attributes['cartier'] = ucfirst($value);
    }

    public function setCommuneAttribute($value){
        return $this->attributes['commune'] = ucfirst($value);
    }

    public function setDistrictAttribute($value){
        return $this->attributes['district'] = ucfirst($value);
    }

    public function setLieuDelivranceAttribute($value){
        return $this->attributes['lieuDelivrance'] = ucfirst($value);
    }

    public function setNumCarteAttribute($value){
        return $this->attributes['numCarte'] = strtoupper($value);
    }
}
