<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Mail;
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
        $calendar = Calendar::addEvents(Event::eventsForFullcalendar());

        return view('event.all', compact('calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $rooms = Room::roomsForSelect();

        return view('event.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateEventRequest $request)
    {
        $event = new Event;
        $event->title = $request->title;
        $event->start = $request->start;
        $event->stop = $request->stop;
        $event->description = $request->description;
        $event->user_id = $request->user()->id;
        $event->room_id = $request->room_id;
        $event->save();
        //dd($request);
        /*
         * Отправка почты
         */
        $data = array(
            'name' => $request->user()->name,
            'room' => Room::find($request->room_id)->name,
            'event' => $event,
        );
        Mail::queue('emails.newconference', $data, function($message) {
            $message->from('noreply@voel.ru', 'Conference Scheduler');
            $message->to(User::emailsList())->subject('Новая конференция');
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
            $event = Event::findOrFail($id);
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
        $event = Event::findOrFail($id);
        $rooms = Room::roomsForSelect();
        return view('event.edit', compact(['event', 'rooms']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateEventRequest $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
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
