<?php

namespace App\Http\Controllers;

use App\Event;
use App\Option;
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

    public function store(Request $request){
        $title = $request->get('title');
        $description = $request->get('description');
        $options = $request->get('options');
        $ended_at = $request->get('ended_at');
        $started_at = $request->get('started_at');

        $event = new Event();
        $event->title = $title;
        $event->description = $description;
        $event->published_at = $started_at;
        $event->ended_at = $ended_at;
        $event->save();

        $options_arr = explode(';', $options);
        foreach ($options_arr as $option){
            if($option){
                $o = new Option();
                $o->content = $option;
                $o->event_id = $event->id;
                $o->save();
            }
        }

        return redirect()->route('event.index');
    }

    public function show($id){
        $event = Event::with('options')->find($id);

        return view('vote', ['event' => $event]);
    }

    public function getInfo($id){
        $event = Event::with('options')->find($id);
        $options = $event->options;

        $total = 0;
        foreach($options as $option){
            $total += $option->vote;
        }

        return [
            'options' => $options,
            'total' => $total
        ];
    }

    public function vote(Request $request){
        $option_id = $request->get('option_id');
        \DB::table('options')->where('id', $option_id)->increment('vote');

        return 'ok';
    }
}
