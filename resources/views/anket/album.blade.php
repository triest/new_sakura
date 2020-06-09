@extends('layouts.lk')

@section('title', 'Фотографии')

@section('content')

    <div class="container">
        <div class="profile-form">

            <button type="button" onclick="upload()">Загрузить1</button>

            <input id="image" name="image" type="file"/>
            <input type="hidden" id="alnumId" value="{{$album->id}}">
            <div class="row">
                @foreach($photos as $item)
                    <div class="col-sm-6 col-12">
                        <a href="{{route('anket.albumItem',['id'=>$user->id,'albumid'=>$item->id])}}">
                            <img width="200" height="200" src="<?php echo asset($item->url)?>">
                            <div class="cell">
                                <div class="cell-overflow">

                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function upload() {
            let upload = document.getElementById("image");
            upload.click();
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });

        let image = document.getElementById("image");
        image.onchange = function (e) {
            let _token = '<?php echo csrf_token(); ?>'
            console.log(image);
            let photo = image.files[0];
            console.log(photo);
            console.log("change");
            //  let data = {_token, image: photo};
            let data = new FormData();
            //   data.append(_token);
            data.append('image', photo);
            let album = document.getElementById("alnumId").value;
            console.log(album);
            data.append('album', album);
            //   formData.append("photo", photo);
            //  formData.append("album", album);
            //  req.open("POST", '/anket/albums/upload/image');
            //req.send(formData);

            $.ajax({

                type: "POST",
                /*                _token: _token,

                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                },
                */
                dataType: "json",

                cashe: false,

                url: "upload/image",

                data,
                contentType: false,
                processData: false,
                success: function (data) {
                }
            })


        }

    </script>
@endsection