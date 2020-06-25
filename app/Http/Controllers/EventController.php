<?php

    namespace App\Http\Controllers;

    use App\City;
    use App\Event;
    use App\EventRequwest;
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

            $events = $user->events()->get();

        }

        public function create(Request $request)
        {
            $city = City::GetCurrentCity();

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

                return view("event.viewmy")->with([
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


                // проверяем запросы от этого пользователя
                $eventRequwest = null;
                if ($user != null) {
                    $eventRequwest = EventRequwest::select(["*"])->where("name", "event")->where("who_id",
                            $user->id)->where("target_id", $id)->get();

                }

                return view("event.view")->with([
                        "event" => $event,
                        "date_begin" => $date[0],
                        "time_begin" => $date[1],
                        "date_applications" => $end[0],
                        "time_applications" => $end[1],
                        "event_requwest" => $eventRequwest
                ]);
            }
        }

        public function inmycity(Request $request)
        {
            if ($request->city) {
                $city = City::get(intval($request->get('city')));
                $events = Event::inMyCity($city);

                $partificator = null;
                $partifucationArray = array();
                foreach ($events as $item) {
                    $partificator = $item->checkUserPartification();
                    if ($partificator != false) {
                        array_push($partifucationArray, $partificator);
                    }
                }

                return response()->json([
                        "events" => $events,
                        "partification" => $partifucationArray,
                ]);
            } else {
                return response()->json();
            }
        }

        public function singup($id)
        {
            $events = Myevent::select([
                    'id',
                    'name',
                    'place',
                    'begin',
                    'description',
                    'max_people',
                    'organizer_id',
            ])->where('id', $id)->first();
            //моё ли это событие
            $auth_user = Auth::user();
            $girl_id = $auth_user->get_girl_id();

            if ($girl_id == $events->organizer_id) {
                return redirect("/myevent/" . $id);
            }

            $days = [
                    'Воскресенье',
                    'Понедельник',
                    'Вторник',
                    'Среда',
                    'Четверг',
                    'Пятница',
                    'Суббота',
            ];
            $months = [
                    'Январь',
                    'Февраль',
                    'Март',
                    'Апрель',
                    'Май',
                    'Июнь',
                    'Июль',
                    'Август',
                    'Сентябрь',
                    'Октябрь',
                    'Ноябрь',
                    'Декабрь',
            ];
            $arr = explode(" ", $events->begin);
            $day_num = date("w", strtotime($arr[0]));
            $day_name = $days[$day_num];
            $d = date_parse_from_format("Y-m-d", $arr[0]);
            $month_name = $months[$d["month"]];
            $day = $d["day"];


            $organizer = Girl::select(['id', 'name', 'main_image'])
                    ->where('id', $events->organizer_id)->first();
            $photo = $events->photo()->get();


            return view('event.singup')->with([
                    'event' => $events,
                    'day_name' => $day_name,
                    'month_name' => $month_name,
                    'day' => $day,
                    'time' => $arr[1],
                    'organizer' => $organizer,
                    'photo' => $photo
                /* 'count' => $count*/
            ]);
        }

        public function check_requwest(Request $request)
        {
            //dump($request);
            $user_id = intval($request->user);
            $event = intval($request->event);
            $eventRequwest = EventRequwest::select(["*"])->where("name", "event")->where("who_id",
                    $user_id)->where("target_id", $event)->first();

            return response()->json(["eventRequwest" => $eventRequwest]);
        }

        public function makeRequwest(Request $request)
        {

            $user_id = intval($request->user);
            $event = intval($request->event);
            $eventRequwest = new EventRequwest();
            $eventRequwest->who_id = $user_id;
            $eventRequwest->target_id = $event;
            $eventRequwest->name = "event";
            $eventRequwest->save();

            return response()->json(true);
        }

        public function accept(Request $request){
         //   dump($request);
       //     die("sads");
            $eventReq = EventRequwest::select(["*"])->where('id',$request->req_id)->first();

            if($eventReq==null){
                return response()->json([false]);
            }
            $eventReq->status="accept";
            $eventReq->save();

            return response()->json([true]);
        }

        public function denided(Request $request){
            $eventReq = EventRequwest::select(["*"])->where('id',$request->req_id)->first();

            if($eventReq==null){
                return response()->json([false]);
            }
            $eventReq->status="denide";
            $eventReq->save();

            return response()->json([true]);
        }

        public function requwestlist($id, Request $request)
        {
           // dump($id);
            // dump($request);
            $event = Event::get($id);
         //   dump($event);
            if ($event == null) {
                return response()->json(null);
            }
            $eventReq = EventRequwest::select(["*"])
                    ->select(['users.id as user_id','users.profile_url' ,'requwest.target_id as event_id','requwest.id as requwest_id','requwest.status as requwest_status'])
                    ->leftJoin('users', 'users.id', '=', 'requwest.who_id')
                    ->where("target_id", $id)->where("requwest.name", "event")

                    ->get();

            return response()->json(["requwest" => $eventReq]);
        }
    }
