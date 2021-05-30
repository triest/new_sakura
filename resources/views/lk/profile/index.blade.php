@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


    <div class="container">
        <div class="profile-form">

            <div class="form-lk_name">Профиль</div>

            <form class="form-lk" action="{{ route('lk.profile.store') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="group">
                    <div class="group-photo_upload">
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }} </div>
                        @endforeach
                        <div class="group-upload_profile">
                            <label class="label_txt"><span></span></label>
                            @if($size!="")
                                <div class="group-file_upload_yes">
                                    <div class="txt" id="txt">/avatarka.jpg ({{$size}}Кб)</div>
                                </div>
                            @else
                                <div class="txt" id="txt"></div>
                            @endif
                            @if($user &&$user->photo_profile_url!=null)
                                <img src="{{asset( "$user->photo_profile_url")}}" height="250px" width="250px">
                            @endif
                            @if(session()->has('photo-error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('photo-error') }}
                                </div>
                            @endif
                        </div>

                        <div class="photo_profile" id="photo_profile" data-remodal-target="upload_img">
                            <input id="file-upload-photo-profile" name="file-upload-photo-profile" type="file"/>
                        </div>
                    </div>
                </div>
                <div class="group">
                    <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Фотографии</a>
                </div>

                <div class="group">
                    <label class="label_txt"><span></span>Имя</label>
                    <div class="group_input">
                        <input type="text" class="input" id="name" name="name"
                               value="{{old('name') ?? $user->name }}">
                    </div>
                    @if($errors->has('name'))
                        <div class="alert alert-danger">
                            <div class="error">{{ $errors->first('name') }}</div>
                        </div>
                    @endif

                    <div class="group">
                        <label class="label_txt"><span></span>Кто вы</label>
                        <div class="group_input">
                            <select name="sex" id="sex">
                                <option value="female" @if($user->sex=='female') selected @endif>Женщина</option>
                                <option value="male" @if($user->sex=='male') selected @endif>Мужчина</option>
                            </select>
                        </div>
                    </div>

                    <div class="group">
                        <label class="label_txt"><span></span>Ищу</label>
                        <div class="group_input">
                            <select name="met" id="met">
                                <option value="female" @if($user->meet=='female') selected @endif>Женщину</option>
                                <option value="male" @if($user->meet=='male') selected @endif>Мужчину</option>
                            </select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>Дата рождения</label>
                                <div class="group_input">
                                    <input type="date" class="input" id="date_birth" name="date_birth"
                                           value="{{old('date_birth') ?? $user->date_birth }}">
                                </div>
                                @if($errors->has('date_birth'))
                                    <div class="alert alert-danger">
                                        <div class="error">{{ $errors->first('date_birth') }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        @if($targets->isNotEmpty())
                            <div class="col-sm-6 col-12">
                                <div class="group">
                                    <label class="label_txt"><span></span>Цель знакомства</label>
                                    @foreach($targets as $item)
                                        <p>
                                            <input class="form-check-input" type="checkbox" value="{{$item->id}}"
                                                   name="target[]"
                                                   @if(in_array($item->id,$anketTarget)) checked="1" @endif >
                                            {{$item->name}}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($interests->isNotEmpty())
                            <div class="col-sm-6 col-12">
                                <div class="group">
                                    <label class="label_txt"><span></span>Интересы</label>
                                    @foreach($interests as $item)
                                        <p>
                                            <input class="form-check-input" type="checkbox" value="{{$item->id}}"
                                                   name="interest[]"
                                                   @if(in_array($item->id,$anketInterests)) checked="1" @endif >
                                            {{$item->name}}
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>Обо мне</label> <br>
                                <textarea name="description" cols="100"
                                          required> {{old('description') ?? $user->description}}</textarea>

                            </div>
                        </div>
                    </div>
                    @if($errors->has('description'))
                        <div class="alert alert-danger">
                            <div class="error">{{ $errors->first('description') }}</div>
                        </div>
                    @endif
                    Отношения:

                    <select name="relation_id" id="relarion">
                        @foreach($relations as $item)
                            <p>
                                <option value="{{$item->id}}"
                                        @if($user->relation_id==$item->id) selected @endif>{{$item->name}}</option>
                            </p>
                        @endforeach
                    </select>
                </div>


                <p class="politics">
                    Нажимая на кнопку &laquo;Продолжить&raquo; Вы даете согласие на обработку данных согласно <a
                            href="#">Правилам</a>
                </p>

                <button class="mt-24 btn-light btn_100 btn-small btn-animate" type="button"
                        data-remodal-target="upload_img" id="buttonTarget" hidden>Продолжить
                </button>
                <button class="btn btn-primary" type="submit">Сохранить
                </button>
                <a href="/" class="btn btn-secondary">Отменить</a>
            </form>

        </div>

    </div>


@endsection
