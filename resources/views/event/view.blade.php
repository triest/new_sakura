@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', $event->name)
@section('content')

    <div class="container" id="app">
        <div class="profile-form">

                <img src="{{asset( "$event->photo_url")}}" alt="" id="profile_image" height="250px">

                @if(Auth::user())
                    <div class="form-group">
                <span class="border border-dark">
                <event-requwest :user="{{Auth::user()}}" :event="{{$event}}"></event-requwest>
                </span>
                    </div>
                @endif
                <div class="form-group">
                    <div class="col-xs-17">
                        {{$event->description}}
                    </div>
                </div>

                <div class="col-xs-11">
                    @if(isset($city) && $city!=null)
                        {{$city}}
                        <br>
                    @endif
                    <label for="title">Место:</label>
                    {{$event->place }}
                </div>
                <div class="col-xs-11">
                    <p>
                        Дата:{{$date_begin}}
                    </p>
                    Время:
                    {{$time_begin}}
                    <p>
                        Заявки принимаються до:
                        {{$date_applications }}      {{$time_applications}}
                    </p>
                </div>
                @if($event->max_people!=null)
                    <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
                        {{$event->max_people}}
                    </label><br>
                @endif
                @if($event->min_people!=null)
                    <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
                        {{$event->max_people}}
                    </label><br>
                @endif

                Фотографии события:

                <a class="btn btn-primary" href="{{route("anket.main")}}">К списку анкет</a>
        </div>
    </div>
@endsection
