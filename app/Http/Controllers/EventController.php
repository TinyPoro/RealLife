<?php

namespace App\Http\Controllers;

use App\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(){
        $events = Event::with('options')->get();

        $hot_events = [];

        $now = Carbon::now()->subHours(2);
        foreach ($events as $event){
            $publishedTime = Carbon::parse($event->published_at);
            if($publishedTime->gte($now)) $hot_events[] = $event;
        }

        return view('main', ['events' => $events, 'hot_events' => $hot_events]);
    }

    public function create(){
        return view('create');
    }
}
