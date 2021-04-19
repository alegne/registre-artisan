<?php
namespace App;
    
use Illuminate\Database\Eloquent\Relations\Pivot;

class ArtisantMetier extends Pivot {
    
    public function artisants()
    {
        return $this->hasMany('App\Artisant');
    }
    
    public function metiers()
    {
        return $this->hasMany('App\Metier');
    }
    
    public function filieres()
    {
        return $this->hasManyThrough('App\Filiere', 'App\Metier');
    }
   
}
