<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //

    public function province(){
        return $this->belongsTo('App\Province');
    }

    public function artisants(){
        return $this->hasMany('App\Artisant');
    }
}
