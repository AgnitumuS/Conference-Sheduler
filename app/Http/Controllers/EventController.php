<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Mail;
use Carbon\Carbon;
use DateTime;
use Calendar;
use App\Event;
use App\Room;
use App\User;

class EventController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];
        $color = '';
        $ev = Event::all();
        $user = Auth::user();

        foreach ($ev as $key => $value)
        {
            //посвечиваем созданые события зеленым если они "свои" 
            //и серым если "чужие"
            ($user === null) ? $color = '#136D27' : ($ev[$key]->user->id === $user->id) ? $color = '#136D27' : $color = 'grey';

            $events[] = Calendar::event(
                            $ev[$key]->title, //. ' | Место проведения: ' . $ev[$key]->room->name . ' | Автор: ' . $ev[$key]->user->name, //event title
                            false, //full day event?
                            new DateTime($ev[$key]->start), //start time (you can also use Carbon instead of DateTime)
                            new DateTime($ev[$key]->stop), //end time (you can also use Carbon instead of DateTime)
                            $ev[$key]->id, //optionally, you can specify an event ID
                            [
                        'color' => $color,
                        'url' => '/event/' . $ev[$key]->id,
                            ]
            );
        }
        $calendar = Calendar::addEvents($events);

        return view('event.all', compact('calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = [];

        foreach (Room::all() as $key => $value)
        {
            $rooms[$value->id] = $value->name;
        }
        return view('event.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255|min:3',
        ]);

        foreach (User::all() as $key=>$value) {
            $emails[] = $value->email; 
        }
        //$emails = array('e.vershkov@voel.ru', 'evn88@ya.ru');
        //dd($emails);
        $event = new Event;
        $event->title = $request->title;
        $event->start = Carbon::parse($request->start);
        $event->stop = Carbon::parse($request->stop);
        $event->description = $request->description;
        $event->user_id = $request->user()->id;
        $event->room_id = $request->room;
        $event->save();

        $data = array(
            'name' => $request->user()->name,
            'room' => Room::find($request->room)->name,
            'event' => $event,
        );
        Mail::queue('emails.newconference', $data, function($message) use ($emails) {
            $message->from('noreply@voel.ru', 'Conference Scheduler');
            $message->to($emails)->subject('Новая конференция');
        });

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id)
        {
            $event = Event::find($id);
            $user = Auth::user();
        }
        return view('event.show', compact(['event', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rooms = [];
        $event = Event::find($id);

        foreach (Room::all() as $key => $value)
        {
            $rooms[$value->id] = $value->name;
        }
        return view('event.edit', compact(['event', 'rooms']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->title = $request->title;
        $event->start = Carbon::parse($request->start);
        $event->stop = Carbon::parse($request->stop);
        $event->description = $request->description;
        $event->user_id = $request->user()->id;
        $event->room_id = $request->room;
        $event->save();
        return redirect('/event/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id)
        {
            Event::destroy($id);
        }
        return redirect('/');
    }

}
