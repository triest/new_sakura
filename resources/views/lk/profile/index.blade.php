@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


    <div class="container">
        <div class="profile-form">

            <div class="form-lk_name">Профиль</div>

            <form class="form-lk" action="{{ route('lk.profileStore') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}


                @if($errors->any())
                    <div class="announcement_p">
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                    </div>
                @endif


                <div class="form-lk_h2">Личные данные</div>

                <div class="group">


                    <div class="group-photo_upload">

                        <div class="group-upload_profile">
                            <label class="label_txt"><span></span>Изображение профиля</label>
                            <div class="group-upload_txt_profile_photo">
                                Загрузите изображение профиля в формате .jpg .png (не более 3Мб)
                            </div>
                            <!--                        <div class="group-file_upload">-->
                            <!--                            <label for="file-upload-photo-profile" class="custom-file-upload">-->
                            <!--                                Прикрепить документ-->
                            <!--                            </label>-->
                            <!--                            <input id="file-upload-photo-profile" type="file"/>-->
                            <!--                        </div>-->
                            @if($size!="")
                                <div class="group-file_upload_yes">
                                    <div class="txt" id="txt">/avatarka.jpg ({{$size}}Кб)</div>
                                </div>
                            @else
                                <div class="txt" id="txt"></div>
                            @endif
                        </div>

                        <div class="photo_profile" id="photo_profile" data-remodal-target="upload_img">

                            <img src="{{ ($user->profile_url!="") ? $user->profile_url : "/home/img/image-placeholder.png"}}"
                                 alt="" id="profile_image">
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
                               value="{{old('first_name') ?? $user->name }}">
                    </div>


                    <div class="group">
                        <label class="label_txt"><span></span>Кто вы</label>
                        <div class="group_input">
                            <select name="sex" id="sex">
                                <option value="famele" @if($user->sex=='famele') selected @endif>Женщина</option>
                                <option value="male" @if($user->sex=='male') selected @endif>Мужчина</option>
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
                                <label class="label_txt"><span></span>Обо мне</label>
                                <textarea name="description" cols="100"
                                          required> {{old('description') ?? $user->description}}</textarea>

                            </div>
                        </div>
                    </div>

                    Отношения:

                    <select name="relation" id="relarion">
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
                <button class="btn btn-primary mt-24 btn-light btn_100 btn-small btn-animate" type="submit">Сохранить</button>
                <a href="/" class="btn btn-secondary">Отменить</a>
            </form>

        </div>

    </div>





@endsection
