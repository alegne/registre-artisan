<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    public function regions(){
        return $this->hasMany('App\Region');
    }
    public function artisants(){
        return $this->hasManyThrough('App\Artisant', 'App\Region');
    }
}
