@extends('layouts.lk')

@section('title', $user->name)

@section('content')


    <div class="container" id="app">
        <div class="profile-form">

            <div class="form-lk_name">{{$user->name}}</div> {{$user->age()}}

            <form class="form-lk" action="{{ route('lk.profileStore') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}


                <div class="form-lk_h2">Личные данные</div>

                <div class="group">


                    <div class="group-photo_upload">

                        <div class="group-upload_profile">
                         <anket-component :user="{{$user}}"></anket-component>
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
                <div class="row">
                    @if($targets->isNotEmpty())
                        <div class="col-sm-6 col-12">
                            <div class="group">
                                <label class="label_txt"><span></span>Цель знакомства</label>
                                @foreach($targets as $item)
                                    <p>
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

                                        {{$item->name}}
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="group">
                            <label class="label_txt"><span></span>Обо мне</label>
                            {{$user->description}}

                        </div>
                    </div>
                </div>


            </form>

        </div>
        <a class="btn btn-primary" href="{{route("anket.main")}}">К списку анкет</a>
    </div>




@endsection