<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Event');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
