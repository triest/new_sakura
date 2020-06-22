<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Event;
    use App\Models\Lk\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class EventController extends Controller
    {
        //
        public function index(Request $request)
        {

        }

        public function my(Request $request)
        {
            $user = Auth::user();
            dump($user);
            $events = $user->events()->get();
            dump($events);
        }

        public function create(Request $request)
        {
            $city = City::GetCurrentCity();
            dump($city);
            return view("event.create")->with(["city" => $city]);
        }

        public function store(Request $request)
        {
            $validatedData = $request->validate([
                    'name' => 'required',
                    'date' => 'date',
                    'time' => 'date_format:H:i',
                    'end_date' => 'date',
                    'end_time' => 'date_format:H:i',
                    'description' => 'required'
            ]);

            dump($request);

            $event = new Event();
            $event->name = $request->name;
            $event->begin = $request->date . " " . $request->time;
            $event->description = $request->description;
            $event->user_id = Auth::user()->id;
            $event->max_people = $request->max;
            $event->min_people = $request->min;
            $event->end_applications = $request->end_date . " " . $request->end_time;
            $event->place = $request->place;
            $event->city_id = $request->city;
            $event->save();

            return redirect()->route('events.view', ['id' => $event->id]);
        }

        public function view($id, Request $request)
        {

            $event = Event::select(['*'])->where('id', $id)->first();

            $user = Auth::user();
            if ($user != null && $user->id == $event->user_id) {
                $date = $event->begin;
                $date = explode(" ", $date);

                $end = $event->end_applications;
                $end = explode(" ", $end);

                $city = City::get($event->city_id);

                return view("event.edit")->with([
                        "event" => $event,
                        "date_begin" => $date[0],
                        "time_begin" => $date[1],
                        "date_applications" => $end[0],
                        "time_applications" => $end[1],
                        "city" => $city
                ]);

            } else {
                $date = $event->begin;
                $date = explode(" ", $date);

                $end = $event->end_applications;
                $end = explode(" ", $end);

                dump($event);
                return view("event.view")->with([
                        "event" => $event,
                        "date_begin" => $date[0],
                        "time_begin" => $date[1],
                        "date_applications" => $end[0],
                        "time_applications" => $end[1]
                ]);
            }


        }
    }
