<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function getStartAttribute(){
        $startTime = Carbon::parse($this->created_at);
        $now = Carbon::now();

        return $startTime->diffForHumans($now);
    }

    public function getEndAttribute(){
        $endTime = Carbon::parse($this->ended_at);
        $now = Carbon::now();

        if($endTime->gte($now)) return $endTime->diffForHumans($now);
        else return "Over";
    }

    public function getPictureAttribute(){
        if(!$this->img) return '';
        return config('app.url')."/img/".$this->img;
    }

    public function getTopOptionAttribute(){
        $top_option = null;

        foreach($this->options as $option){
            if(is_null($top_option)) $top_option = $option;
            else{
                if($option->vote > $top_option->vote) $top_option = $option;
            }
        }

        return $top_option;
    }

    public function options(){
        return $this->hasMany('App\Option');
    }
}
