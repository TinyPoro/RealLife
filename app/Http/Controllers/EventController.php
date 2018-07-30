<?php

namespace App\Http\Controllers;

use App\Event;
use App\Option;
use App\User;
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

        return redirect()->route('event.complete', ['id' => $event->id]);
    }

    public function complete($id){
        return view('complete', ['id' => $id]);
    }

    public function show($id){
        $event = Event::with('options')->find($id);

        $options = $event->options;

        $users = $event->users;

        $check_list = [];

        foreach($options as $option){
            foreach($users as $user){
                if($this->inCollection($user, $option->users)) $check_list[$option->id][$user->id] = 1;
                else $check_list[$option->id][$user->id] = 0;
            }
        }

        return view('show1', ['event' => $event, 'check_list' => $check_list, 'users' => $users]);
    }

    public function inCollection($entry, $collection){
        foreach ($collection as $e){
            if($e->id == $entry->id) return true;
        }

        return false;
    }

    public function getInfo($id){
        $event = Event::with('options')->find($id);
        $options = $event->options;

        $users = $event->users;

        $check_list = [];

        foreach($options as $option){
            foreach($users as $user){
                if($this->inCollection($user, $option->users)) $check_list[$option->id][$user->id] = 1;
                else $check_list[$option->id][$user->id] = 0;
            }
        }

        return [
            'options' => $options,
            'check_list' => $check_list,
            'users' => $users
        ];
    }

    public function vote(Request $request){
        try {
            $optionIds = $request->get('optionIds');
            $name = $request->get('name');
            $event_id = $request->get('event_id');

            $suffix = '';

            do {
                $add_name = $name . ' ' . $suffix;

                $user = \DB::table('users')->where('name', $add_name)->get();

                if ($suffix == '') $suffix = 1;
                else $suffix++;
            } while ($user->count() > 0);

            //thêm user
            $user = new User();
            $user->name = $add_name;
            $user->event_id = $event_id;
            $user->save();

            foreach ($optionIds as $optionId) {
                \DB::table('option_user')->insert(
                    ['option_id' => $optionId, 'user_id' => $user->id]
                );
            }

            return $add_name;
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    public function getBlade1(Request $request){
        $id = $request->get('id');

        $user = User::find($id);

        return view('temp.user_participant', ['user' => $user]);
    }
}
