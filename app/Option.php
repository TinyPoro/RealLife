<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
