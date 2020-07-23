@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


    <div class="container">
        <div class="profile-form">
            <div class="group">
                <a href="{{route("anket.albums",['id'=>$user->id])}}" class="personal-area">Альбомы</a>
                <a href="{{route("anket.view",['id'=>$user->id])}}" class="personal-area">Анкета</a>
            </div>
            <div class="group">
                @if($album->canUpload())
                   @include('anket.uploadPhoto')
                @endif
            </div>
            <div class="row">
                @foreach($photos as $item)
                    <div class="col-sm-6 col-12">
                        <div class="group-photo_upload">
                            <div id="photo_profile" data-remodal-target="show_img" onclick="openPhoto({{$item}})">
                                <a href="{{route('anket.albumItem',['id'=>$user->id,'albumid'=>$item->id])}}">
                                    <img width="200" height="200" src="<?php echo asset($item->url)?>">
                                    <div class="cell">
                                        <div class="cell-overflow">

                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>


        <div class="remodal" data-remodal-id="show_img" id="modal" role="dialog" aria-labelledby="modal1Title"
             aria-describedby="modal1Desc">

            <div class="web-block_popup">
                <div class="row">
                    <div class="web-block_item" onclick="click_profile_image_upload()">
                        <img id="image" name="image" src="/home/img/flat-color-icons_webcam.svg" alt="..">
                        <div class="web-block_txt">
                            Загружено:
                            <div class="txt" id="txt"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        function openPhoto(photo) {
            console.log(photo)
            let src = document.getElementById("image");
            image.src = photo.url;
            let txt = document.getElementById("txt");
            txt.innerText = photo.created_at;
        }
    </script>
@endsection