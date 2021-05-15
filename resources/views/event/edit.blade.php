@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', $event->name)
@section('content')

    <div class="container" id="app">
        <div class="profile-form">


            <form class="form-lk" action="{{route('event.update',['event'=>$event->id])}}" method="post"
                  enctype="multipart/form-data">
                {{ csrf_field() }}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <input type="hidden" name="city_id" value="{{$city->id}}"> {{$city->name}}

                <div class="form-group">
                    <div class="col-xs-11">
                        <label for="title">Имя:</label><br>
                        <input type="text" class="form-control" id="name" name="name" value="{{$event->name}}"
                               placeholder="Название события"
                               required>
                    </div>
                    @if($errors->has('name'))
                        <font color="red"><p>  {{$errors->first('name')}}</p></font>
                    @endif
                </div>
                <br>
                <div class="form-group">
                    Фотография события:
                    <img src="{{asset( "$event->photo_url")}}" alt="" id="profile_image" height="250px">

                    <input type="file" id="images" accept="image/*" name="file" value="{{ old('file')}}">
                    @if($errors->has('file'))
                        <font color="red"><p>  {{$errors->first('file')}}</p></font>
                    @endif
                </div>
                <div class="form-group">
                    <div class="col-xs-17">
                        <label for="exampleInputFile">Описание события:</label><br>
                        <textarea name="description" rows="2" required>{{$event->description}} </textarea>
                    </div>
                </div>
                @if($errors->has('description'))
                    <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
                @endif

                <div class="col-xs-11">



                    <br>
                    <label for="title">Место:</label>
                    <input type="text" class="form-control" id="place" name="place" value="{{$event->place }}"
                           placeholder="место события"
                           required>

                    @if($errors->has('place'))
                        <font color="red"><p>  {{$errors->first('place')}}</p></font>
                    @endif
                </div>
                <div class="form-group">
                    Статус:
                    <select name="status" id="status">
                        @foreach($statuses as $item)
                            <p>
                                <option value="{{$item->id}}"
                                        @if($event->status_id==$item->id) selected @endif>{{$item->name}}</option>
                            </p>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-11">
                    <div class="form-group">
                        <p>
                            Дата:
                            <input type="date" id="date" name="date" value="{{$date_begin}}" required>
                            @if($errors->has('date'))
                                <font color="red">  {{$errors->first('date')}}</font>
                            @endif
                        </p>
                        Время:
                        <input type="time" id="time" name="time" value="{{$time_begin}}">
                        @if($errors->has('time'))
                            <font color="red"><p>  {{$errors->first('time')}}</p></font>
                        @endif
                    </div>
                    <div class="form-group">
                        Заявки принимаються до:
                        <input type="date" id="end_date" name="end_date" value="{{$date_applications }}" required>
                        @if($errors->has('date'))
                            <font color="red">  {{$errors->first('end_date')}}</font>
                        @endif
                    </div>
                    <div class="form-group">
                        Время:
                        <input type="time" id="time" name="time_end" value="{{$time_applications}}">
                        @if($errors->has('time'))
                            <font color="red">
                                {{$errors->first('time')}}</font>
                        @endif
                    </div>
                </div>
                <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="max" id="min" min="1" value="{{$event->max_people}}" checked>
                </label><br>

                <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="min" id="min" min="1" value="{{$event->min_people}}" checked>
                </label><br>


                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{route('events.view',['id'=>$event->id])}}" class="btn btn-secondary">Отменить</a>
            </form>
        </div>
    </div>
@endsection
