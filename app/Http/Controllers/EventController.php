<?php

    namespace App\Http\Controllers;

    use App\Builders\EventBuilder;
    use App\Http\Requests\StoreEvent;
    use App\Models\City;
    use App\Models\Event;
    use App\Models\EventRequest;
    use App\Models\Lk\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class EventController extends Controller
    {
        //
        public function index(Request $request)
        {

        }

        public function my()
        {
            $user = Auth::user();

            $events = $user->events()->get();
            return response()->json(['events' => $events]);
        }

        public function create()
        {
            $city = City::getCurrentCity();

            return view("event.create")->with(["city" => $city]);
        }

        public function store(StoreEvent $request)
        {
            $builder = new EventBuilder();
            $builder->setName($request->name);
            $builder->setDescription($request->description);
            $builder->setBegin($request->date . " " . $request->time);
            $builder->setCityId($request->city);
            $builder->setPlace($request->place);
            $builder->setMaxPeople($request->max);
            $builder->setMinPiople($request->min);
            $builder->setEndApplications($request->end_date . " " . $request->time_end);
            $event = $builder->getResult();
            if (!is_object($event)) {
                return redirect()->back()->withErrors(['msg' => $event])->withInput();
            }
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
                $eventRequest = null;
                if ($user != null) {
                    $eventRequest = EventRequest::select(["*"])->where("name", "event")->where("who_id",
                            $user->id)->where("target_id", $id)->get();

                }

                return view("event.view")->with([
                        "event" => $event,
                        "date_begin" => $date[0],
                        "time_begin" => $date[1],
                        "date_applications" => $end[0],
                        "time_applications" => $end[1],
                        "event_request" => $eventRequest
                ]);
            }
        }

        public function inmycity(Request $request)
        {
            if ($request->city) {
                $city = City::get(intval($request->get('city')));
                $events = Event::inMyCity($city);

                $participator = null;
                $partifucationArray = array();

                foreach ($events as $item) {
                    $participator = $item->checkUserPartification();
                    if ($participator != false) {
                        array_push($partifucationArray, $participator);
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
            $events = Event::get($id);
            //моё ли это событие
            $auth_user = Auth::user();
            $girl_id = $auth_user->id;

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


            $organizer = User::select(['id', 'name', 'main_image'])
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

        public function check_request(Request $request)
        {
            $user_id = intval($request->user);
            $event = intval($request->event);
            $eventRequwest = EventRequest::select(["*"])->where("name", "event")->where("who_id",
                    $user_id)->where("target_id", $event)->first();

            return response()->json(["eventRequwest" => $eventRequwest]);
        }

        public function makeRequest(Request $request)
        {

            $user_id = intval($request->user);
            $event = intval($request->event);
            $eventRequwest = new EventRequest();
            $eventRequwest->who_id = $user_id;
            $eventRequwest->target_id = $event;
            $eventRequwest->name = "event";
            $eventRequwest->save();

            return response()->json(true);
        }

        public function accept(Request $request)
        {
            $eventReq = EventRequest::getItem($request->req_id);

            if ($eventReq == null) {
                return response()->json([false]);
            }
            $eventReq->status = "accept";
            $eventReq->save();

            return response()->json([true]);
        }

        public function denied(Request $request)
        {
            $eventReq = EventRequest::getItem($request->req_id);
            if ($eventReq == null) {
                return response()->json([false]);
            }
            $eventReq->denied();

            return response()->json([true]);
        }

        public function requestList($id, Request $request)
        {
            $event = Event::get($id);
            if ($event == null) {
                return response()->json(null);
            }
            $eventReq = EventRequest::select(["*"])
                    ->select([
                            'users.id as user_id',
                            'users.profile_url',
                            'request.target_id as event_id',
                            'request.id as requwest_id',
                            'request.status as requwest_status'
                    ])
                    ->leftJoin('users', 'users.id', '=', 'request.who_id')
                    ->where("target_id", $id)->where("request.name", "event")
                    ->get();

            return response()->json(["request" => $eventReq]);
        }
    }
