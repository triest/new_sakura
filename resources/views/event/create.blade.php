@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', "Создать событие")
@section('content')

    <div class="container" id="app">
        <div class="profile-form">


            <form class="form-lk" action="{{route('events.store')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    @if($errors->any())
                        <font color="red"><p>
                            <h4>{{$errors->first()}}</h4>
                        </font>
                    @endif

                        @if (session('error'))
                            <div class="alert alert-danger text-center msg" id="error">
                                <strong>{{ session('error') }}</strong>
                            </div>
                        @endif

                    <div class="col-xs-11">
                        <label for="title">Имя:</label><br>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                               placeholder="Название события"
                               required>
                    </div>
                    @if($errors->has('name'))
                        <font color="red"><p>  {{$errors->first('name')}}</p></font>
                    @endif
                </div>
                Фотография события:
                <input type="file" id="image" accept="image/*" name="file" value="{{ old('file')}}">
                @if($errors->has('image'))
                    <font color="red"><p>  {{$errors->first('file')}}</p></font>
                @endif

                <div class="form-group">
                    <div class="col-xs-17">
                        <label for="exampleInputFile">Описание события:</label><br>
                        <textarea name="description" rows="2" required> {{old('description')}} </textarea>
                    </div>
                </div>
                @if($errors->has('description'))
                    <font color="red"><p class="errors">{{$errors->first('description')}}</p></font>
                @endif

                <div class="col-xs-11">

                    <input type="hidden" name="city_id" value="{{$city->id}}"> {{$city->name}}

                <!--
            <label>Выбирите из списка:
                <select id="city" class="city" style="width: 200px" name="city" required>
                </select>
            </label> -->
            @if($errors->has('city'))
                    <font color="red"><p>  {{$errors->first('city')}}</p></font>
            @endif


                    <br>
                    <label for="title">Место:</label>
                    <input type="text" class="form-control" id="place" name="place" value="{{ old('place') }}"
                           placeholder="место события"
                           required>

                    @if($errors->has('place'))
                        <font color="red"><p>  {{$errors->first('place')}}</p></font>
                    @endif
                </div>
                <div class="col-xs-11">
                    <p>
                        Дата:
                        <input type="date" id="date" name="date" value="{{ old('date') }}" required>
                        @if($errors->has('date'))
                            <font color="red">  {{$errors->first('date')}}</font>
                        @endif
                    </p>
                    Время:
                    <input type="time" id="time" name="time" value="{{ old('time') }}">
                    @if($errors->has('time'))
                        <font color="red"><p>  {{$errors->first('time')}}</p></font>
                    @endif


                    <p>
                        Заявки принимаються до:
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                        @if($errors->has('date'))
                            <font color="red">  {{$errors->first('end_date')}}</font>
                        @endif
                    </p>
                    <p>
                        Время:
                        <input type="time" id="time" name="time_end" value="{{ old('time_end') }}">
                        @if($errors->has('time'))
                            <font color="red">
                                {{$errors->first('time')}}</font>
                        @endif
                    </p>
                </div>
                <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="max" id="min" min="1" value="{{ old('min') }}" checked>
                </label><br>

                <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="min" id="min" min="1" value="{{ old('max') }}" checked>
                </label><br>


                Фотографии события:
                <input type="file" id="images" accept="image/*" name="file[]" value="{{ old('file')}}">
                @if($errors->has('file'))
                    <font color="red"><p>  {{$errors->first('file')}}</p></font>
                @endif


                <button type="submit" class="btn btn-primary">Создать событие</button>
            </form>
        </div>
    </div>
@endsection
