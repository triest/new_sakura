@extends('layouts.lk', ['title' => 'Создать событие'])
@section('title', $event->name)
@section('content')

    <div class="container" id="app">
        <div class="profile-form">


            <form class="form-lk" action="{{route('events.store')}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
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


                    <label>Выбирите из списка:
                        <input type="hidden" name="city_id" value="{{$city}}">
                    </label>
                    @if($errors->has('city'))
                        <font color="red"><p>  {{$errors->first('city')}}</p></font>
                    @endif

                    <script>
                        function findCity() {
                            var inputcity = document.getElementById('cityname').value;
                            console.log(inputcity);
                            var x = document.getElementById("city");
                            var option = document.createElement("option");
                            axios.get('/findcity/' + inputcity, {
                                params: {}
                            })
                                .then((response) => {
                                    var data = response.data;
                                    $('#city').empty();
                                    for (var i = 0; i <= data[0].length; i++) {
                                        $('#city').append('<option value="' + data[0][i].id_city + '">' + data[0][i].name + '</option>');
                                    }
                                });
                        }

                    </script>
                    -->
                    <br>
                    <label for="title">Место:</label>
                    <input type="text" class="form-control" id="place" name="place" value="{{$event->place }}"
                           placeholder="место события"
                           required>

                    @if($errors->has('place'))
                        <font color="red"><p>  {{$errors->first('place')}}</p></font>
                    @endif
                </div>
                <div class="col-xs-11">
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


                    <p>
                        Заявки принимаються до:
                        <input type="date" id="end_date" name="end_date" value="{{$date_applications }}" required>
                        @if($errors->has('date'))
                            <font color="red">  {{$errors->first('end_date')}}</font>
                        @endif
                    </p>
                    <p>
                        Время:
                        <input type="time" id="time" name="time_end" value="{{$time_applications}}">
                        @if($errors->has('time'))
                            <font color="red">
                                {{$errors->first('time')}}</font>
                        @endif
                    </p>
                </div>
                <label for="max">Максимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="max" id="min" min="1" checked>
                </label><br>

                <label for="min">Минимальное число участников (если нет ограничения, оставьте пустым):
                    <input type="number" name="min" id="min" min="1" checked>
                </label><br>


                Фотографии события:
                <input type="file" id="images" accept="image/*" name="file[]" value="{{ old('file')}}">
                @if($errors->has('file'))
                    <font color="red"><p>  {{$errors->first('file')}}</p></font>
                @endif


                <button type="submit" class="btn btn-default">Создать событие</button>
            </form>
        </div>
    </div>
@endsection