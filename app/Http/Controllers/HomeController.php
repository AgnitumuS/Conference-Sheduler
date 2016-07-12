<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Calendar;
use App\Event;
use DateTime;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $events = [];

        $ev = Event::all();
        //dd($ev[0]->user);
        foreach ($ev as $key => $value)
        {
            $events[] = Calendar::event(
                            $ev[$key]->title . ' | Место проведения: ' . $ev[$key]->room->name . ' | Автор: ' . $ev[$key]->user->name, //event title
                            false, //full day event?
                            new DateTime($ev[$key]->start), //start time (you can also use Carbon instead of DateTime)
                            new DateTime($ev[$key]->stop), //end time (you can also use Carbon instead of DateTime)
                            $ev[$key]->id, //optionally, you can specify an event ID
                            [
                                'color' => 'green',
                                'url' => '/event/' . $ev[$key]->id,
                            ]
            );
        }

        $calendar = Calendar::addEvents($events);
        return view('home', compact('calendar'));
    }
    
    public function view(Requests $id)
    {
        dd($id);
    }

}
