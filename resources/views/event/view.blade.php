@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', $event->name)
@section('content')

    <div class="container" id="app">
        <div class="profile-form">


            <div class="form-group">
                <div class="col-xs-11">
                    {{$event->name}}
                </div>
            </div>

            <event-requwest :event="{{$event}}" :user="{{ Auth::user()}}"></event-requwest>
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
                    {{$date_applications }}
                </p>
                <p>
                    Время:
                    {{$time_applications}}
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

        </div>
    </div>
@endsection