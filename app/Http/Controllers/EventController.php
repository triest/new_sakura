<?php

namespace App\Http\Controllers;

use App\Builders\EventBuilder;
use App\EventStatus;
use App\Exceptions\ExceptionWithMessageForUser;
use App\Http\Requests\StoreEvent;
use App\Models\City;
use App\Models\Event;
use App\Models\EventRequest;
use App\Models\Lk\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    //
    public function index(Request $request)
    {
    }

    public function myEventsList(Request $request)
    {
        $user = Auth::user();
        if(!$user){
            abort(404);
        }

        $events = $user->events()->with(['status'])->orderBy('begin', 'desc')->get();

        if ($request->ajax()) {
            return response()->json(['events' => $events]);
        }

        return view('event.eventList')->with(['events' => $events]);
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
        $builder->setCityId($request->city_id);
        $builder->setPlace($request->place);
        $builder->setMaxPeople($request->max);
        $builder->setMinPiople($request->min);
        $builder->setEndApplications($request->end_date . " " . $request->time_end);

        $event = $builder->getResult();

        if (!is_object($event)) {
            return redirect()->back()->withErrors(['msg' => $event])->withInput();
        }
        if ($request->hasFile('file')) {
            if ($event->photo != null) {
                Storage::delete($event->photo);
            }
            $path = $request->file('file')->store('public/event');
            $event->photo_url = 'storage/app/' . $path;
            $event->photo = $path;
        }


        $event->save();

        return redirect()->route('events.view', ['id' => $event->id]);
    }

    public function edit($id){
           $event=Event::get($id);
           if(!$event){
               abort(404);
           }

        $arr = explode(' ', $event->begin);
        $date = $arr[0];
        $time = $arr[1];


        $end_application=  $arr = explode(' ', $event->end_applications);

        $statuses=EventStatus::select(['*'])->get();
        $city = City::getCurrentCity();

        return view('event.edit')->with(
                [
                        'event' => $event,
                        'date_begin' => $date,
                        'time_begin' => $time,
                        'date_applications' => $end_application[0],
                        'time_applications' => $end_application[1],
                        'statuses' => $statuses,
                         'city' => $city
                ]
        );
    }


    public function update($id,StoreEvent $request){

        $event=Event::get($id);
        if(!$event){
          return back()->withErrors(['msg'=>'Ошибка! Обратитесь к администратору']);
        }
        $builder = new EventBuilder($event);
        $builder->setName($request->name);
        $builder->setDescription($request->description);
        $builder->setBegin($request->date . " " . $request->time);
        $builder->setCityId($request->city_id);
        $builder->setPlace($request->place);
        $builder->setMaxPeople($request->max);
        $builder->setMinPeople($request->min);
        $builder->setEndApplications($request->end_date . " " . $request->time_end);

        $event = $builder->getResult();

        if ($request->hasFile('file')) {
            if ($event->photo != null) {
                Storage::delete($event->photo);
            }
            $path = $request->file('file')->store('public/event');
            $event->photo_url = 'storage/app/' . $path;
            $event->photo = $path;
        }


        if(!is_string($event)) {
            $event->save();
        }else{
            return back()->withErrors(['msg'=>$event]);
        }

        return redirect()->route('events.view', ['id' => $event->id]);
    }


    public function view($id, Request $request)
    {
        $event = Event::select(['*'])->with('status', 'user')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }

        $user = Auth::user();
        if ($user != null && $user->id == $event->user_id) {
            $date = $event->begin;
            $date = explode(" ", $date);

            $end = $event->end_applications;

            $end = explode(" ", $end);

            $city = City::get($event->city_id);


            return view("event.viewmy")->with(
                    [
                            "event" => $event,
                            "date_begin" => $date[0],
                            "time_begin" => $date[1],
                            "date_applications" => $end[0],
                            "time_applications" => $end[1],
                            "city" => $city
                    ]
            );
        } else {
            $date = $event->begin;
            $date = explode(" ", $date);

            $end = $event->end_applications;
            $end = explode(" ", $end);


            // проверяем запросы от этого пользователя
            $eventRequest = null;
            if ($user != null) {
                $eventRequest = EventRequest::select(["*"])->with("event")->where(
                        "user_id",
                        $user->id
                )->where("event_id", $id)->get();
            }


            return view("event.view")->with(
                    [
                            "event" => $event,
                            "date_begin" => $date[0],
                            "time_begin" => $date[1],
                            "date_applications" => $end[0],
                            "time_applications" => $end[1],
                            "event_request" => $eventRequest
                    ]
            );
        }
    }

    public function inmycity(Request $request)
    {
        if ($request->city) {
            $city = City::findOrFail($request->get('city'));

            $events = Event::inMyCity($city);

            $participator = null;
            $partifucationArray = array();

            foreach ($events as $item) {
                $participator = $item->checkUserParticipation();
                if ($participator != false) {
                    array_push($partifucationArray, $participator);
                }
            }


            return response()->json(
                    [
                            "events" => $events,
                            "partificators" => $partifucationArray,
                    ]
            );
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


        return view('event.singup')->with(
                [
                        'event' => $events,
                        'day_name' => $day_name,
                        'month_name' => $month_name,
                        'day' => $day,
                        'time' => $arr[1],
                        'organizer' => $organizer,
                        'photo' => $photo
                    /* 'count' => $count*/
                ]
        );
    }

    public function check_request(Request $request)
    {
        $user_id = intval($request->user);
        $event = intval($request->event);
        $event=Event::get($event);
        if(!$event){
            return false;
        }

        $partificator=$event->checkUserParticipation();



        return response()->json(["eventRequest" => $partificator]);
    }

    public function makeRequest(Request $request)
    {
        $user_id = intval($request->user);
        $event = Event::get(intval($request->event));
        if(!$event){
            return response()->json(['result'=>false]);
        }
         if($result=$event->makeRequest()){
             return response()->json(['result'=>$result]);
         }else{
            return  response()->json(['result'=>false,'message'=>$result]);
         }
    }

    public function accept(Request $request)
    {
        $eventReq = EventRequest::getItem($request->req_id);

        if ($eventReq == null) {
            return response()->json([false]);
        }
        $eventReq->accept();

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

    public function requestList($id = null, Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(["request" => "not fount"]);
        }

        $user = User::select(['*'])->where(['id' => $user->id])->first();
        if ($id == null) {
            $req = $user->getEventRequests(true)->get();
        } else {
            $event = Event::get($id);
            if (!$event) {
                return response()->json(["request" => "not fount"]);
            }
            $req = $event->request()->with(['status', 'event', 'user'])->get();
        }
        $event_request_count = $req->count();
        $event_request = $req;


        return response()->json(["request_count" => $event_request_count, 'request_list' => $event_request]);
    }


    //позвращает число непрочитанных запросов на события, как моих так и на мои
    public function numberUnreadRequested(Request $request)
    {
        $user = Auth::user();


        if (!$user) {
            return response()->json(["request" => "not fount"]);
        }
        $user = User::select(['*'])->where(['id' => $user->id])->first();
        $event_request_count = $user->getEventRequests(true)->count();


        return response()->json(["request_count" => $event_request_count]);
    }
}
