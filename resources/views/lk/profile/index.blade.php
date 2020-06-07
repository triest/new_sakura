@extends('layouts.lk')

@section('title', 'Профиль')

@section('content')


    <div class="container">
        <div class="profile-form">

            <div class="form-lk_name">Профиль</div>

            <form class="form-lk" action="{{ route('lk.profileStore') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                @if ($errors->has('last_name'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </div>
                @endif
                @if ($errors->has('first_name'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </div>
                @endif
                @if ($errors->has('middle_name'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('middle_name') }}</strong>
                    </div>
                @endif
                @if ($errors->has('position'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('position') }}</strong>
                    </div>
                @endif

                @if ($errors->has('name_company'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('name_company') }}</strong>
                    </div>
                @endif
                @if ($errors->has('phone'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </div>
                @endif
                @if ($errors->has('job_phone'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('job_phone') }}</strong>
                    </div>
                @endif
                @if ($errors->has('email'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('email') }}</strong>
                    </div>
                @endif
                @if ($errors->has('work_email'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('work_email') }}</strong>
                    </div>
                @endif
                @if ($errors->has('inn'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('inn') }}</strong>
                    </div>
                @endif
                @if ($errors->has('date_birth'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('date_birth') }}</strong>
                    </div>
                @endif
                @if ($errors->has('file-upload-photo-profile'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('file-upload-photo-profile') }}</strong>
                    </div>
                @endif
                @if ($errors->has('file-upload-doc'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('file-upload-doc') }}</strong>
                    </div>
                @endif
                @if ($errors->has('file-upload-photo'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('file-upload-photo') }}</strong>
                    </div>
                @endif
                @if ($errors->has('education'))
                    <div class="announcement_p">
                        <strong>{{ $errors->first('education') }}</strong>
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
                    <label class="label_txt"><span></span>Фамилия</label>
                    <div class="group_input">
                        <input type="text" class="input" id="last_name" name="last_name"
                               value="{{old('last_name') ?? $user->last_name }}">
                    </div>
                </div>

                <div class="group">
                    <label class="label_txt"><span></span>Имя</label>
                    <div class="group_input">
                        <input type="text" class="input" id="first_name" name="first_name"
                               value="{{old('first_name') ?? $user->first_name }}">
                    </div>
                </div>

                <div class="group">
                    <label class="label_txt"><span></span>Отчество</label>
                    <div class="group_input">
                        <input type="text" class="input" id="middle_name" name="middle_name"
                               value="{{old('middle_name') ?? $user->middle_name }}">
                    </div>
                </div>

                <div class="group">
                    <label class="label_txt"><span></span>ИИН</label>
                    <div class="group_input">
                        <input type="text" class="input" id="inn" name="inn" value="{{old('inn') ?? $user->inn }}">
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

                    <div class="col-sm-6 col-12">
                        <div class="group">
                            <label class="label_txt"><span></span>Образование</label>

                            <div class="select-box">

                                <select class="nice-select wide" id="education" name="education" class="list">
                                    <option class="current" value="">
                                        Выберите
                                    </option>
                                    <option class="current" value="higher"
                                            @if($user->education=="higher")selected @endif>Высшее
                                    </option>
                                    <option class="current" value="middle"
                                            @if($user->education=="middle")selected @endif>Среднее
                                    </option>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="form-lk_h2">Ваши контакты</div>

                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="group">
                            <label class="label_txt"><span></span>E-mail</label>
                            <div class="group_input">
                                <input type="text" class="input" id="contact_email" name="contact_email"
                                       value="{{old('contact_email') ?? $user->email }}">
                            </div>
                        </div>


                        <div class="group">
                            <label class="label_txt">E-mail (Рабочий)</label>
                            <div class="group_input">
                                <input type="text" class="input" id="work_email" name="work_email"
                                       value="{{old('work_email') ?? $user->work_email }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="group">
                            <label class="label_txt"><span></span>Телефон</label>
                            <div class="group_input">
                                <input type="text" class="input" id="phone" name="phone"
                                       value="{{old('phone') ?? $user->phone }}">
                            </div>
                        </div>

                        <div class="group">
                            <label class="label_txt">Телефон (Рабочий)</label>
                            <div class="group_input">
                                <input type="text" class="input" id="job_phone" name="job_phone"
                                       value="{{old('job_phone') ?? $user->job_phone }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-lk_h2">Рабочие данные</div>

                <div class="group">
                    <label class="label_txt"><span></span>Организация</label>
                    <div class="group_input">
                        <input type="text" class="input" id="name_company" name="name_company"
                               value="{{old('name_company') ?? $user->name_company }}">
                    </div>
                </div>

                <div class="group">
                    <label class="label_txt"><span></span>Должность</label>
                    <div class="group_input">
                        <input type="text" class="input" name="position" id="position"
                               value="{{old('position') ?? $user->position }}">
                    </div>
                </div>

                <div class="form-lk_h2">Ваши документы</div>

                <div class="row">
                    <div class="col-sm-6 col-12">
                        <div class="group group-upload">
                            <label class="label_txt"><span></span>Удостоверение личности</label>
                            <div class="group-upload_txt">
                                Прикрепите сканы документа формате .jpg .png (не более 3Мб)
                            </div>
                            <div class="group-file_upload">
                                <label for="file-upload-doc" class="custom-file-upload">
                                    Прикрепить документ
                                </label>
                                <input id="file-upload-doc" name="file-upload-doc" type="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="group group-upload">
                            <label class="label_txt"><span></span>Фотографии 3×4</label>
                            <div class="group-upload_txt">
                                Прикрепите фотографии 3×4 формате .jpg .png (не более 3Мб)
                            </div>
                            <div class="group-file_upload">
                                <label for="file-upload-photo" class="custom-file-upload">
                                    Прикрепить фотографию
                                </label>
                                <input id="file-upload-photo" name="file-upload-photo" type="file"/>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="politics">
                    Нажимая на кнопку &laquo;Продолжить&raquo; Вы даете согласие на обработку данных согласно <a
                            href="#">Правилам</a>
                </p>

                <button class="mt-24 btn-light btn_100 btn-small btn-animate" type="button"
                        data-remodal-target="upload_img_crop" id="buttonTarget" hidden>Продолжить
                </button>
                <button class="mt-24 btn-light btn_100 btn-small btn-animate" type="submit">Продолжить</button>
            </form>

        </div>

    </div>

    <div class="remodal" data-remodal-id="upload_img" id="modal" role="dialog" aria-labelledby="modal1Title"
         aria-describedby="modal1Desc">

        <div class="web-block_popup">
            <div class="d-flex justify-content-between">
                <div class="web-block_title">Загрузка фото</div>
                <button data-remodal-action="close" class="web-block_close remodal-close"></button>
            </div>
            <div class="row">
                <div class="col-sm-6 col-12">
                    <div class="web-block_item" onclick="click_profile_image_upload()">
                        <img src="/home/img/flat-color-icons_webcam.svg" alt="..">
                        <div class="web-block_txt">
                            А ещё ключевые особенности структуры проекта, превозмогая сложившуюся непростую
                            экономическую ситуацию, объективно рассмотрены соответствующими инстанциями.
                        </div>
                        <div class="group-file_upload">
                            <label for="file-upload-photo-profile_web" class="custom-file-upload w100">
                                Дать доступ Веб-камере
                            </label>
                            <input id="file-upload-photo-profile_web" type="file">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12">
                    <div class="web-block_item" onclick="click_profile_image_upload()">
                        <img src="/home/img/flat-color-icons_self-service-kiosk.svg" alt="..">
                        <div class="web-block_txt">
                            А ещё ключевые особенности структуры проекта, превозмогая сложившуюся непростую
                            экономическую ситуацию, объективно рассмотрены соответствующими инстанциями.
                        </div>
                        <div class="group-file_upload">
                            <input type="file" name="image" id="image" class="image">
                            <label for="file-upload-photo-profile_upload" class="custom-file-upload w100"
                                   onclick="click_profile_image_upload()">
                                Загрузить фотографию
                            </label>

                            <script>
                                function click_profile_image_upload() {
                                    let upload = document.getElementById("image");
                                    console.log("upload")
                                    console.log(upload)
                                    upload.click();
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="remodal" id="remodal" data-remodal-id="upload_img_crop" role="dialog" aria-labelledby="modal1Title"
         aria-describedby="modal1Desc">


        <div class="web-block_popup">

            <div class="d-flex justify-content-between">
                <div class="web-block_title">Фото с вебкамеры</div>
                <button data-remodal-action="close" id="closeUploadModal"
                        class="web-block_close remodal-close"></button>
            </div>

            <div class="announcement_txt mt-20">
                Выберите область фотографии который будет отображаться в профиле
            </div>


            <div class="web-block_img mt-20">
                <img id="image2" src="https://avatars0.githubusercontent.com/u/3456749">
            </div>

            <div class="group_btn">
                <button class="btn-light btn-small btn_height50 btn-animate" data-dismiss="modal">Загрузить
                    снова
                </button>
                <button class="btn-blue btn-small btn_height50 btn-animate" id="crop">Готово</button>
            </div>
        </div>
    </div>




    <script>

        $$(() => {


            var $modal = $('#remodal').remodal();


            let image = document.getElementById('image2');

            let cropper;
            $("body").on("change", ".image", function (e) {

                let files = e.target.files;

                let done = url => {

                    image = document.getElementById('image2');
                    image.src = url;

                    // this.onShowModal();

                    cropper = null;
                    onShowModal();

                    $modal.open();
                    // $modal.modal('show');
                    let target = document.getElementById("buttonTarget");
                    target.click();

                };

                let reader;

                let file;

                let url;


                if (files && files.length > 0) {

                    file = files[0];

                    console.log('file =>', file);

                    if (FileReader) {

                        reader = new FileReader();

                        reader.onload = function (e) {

                            done(reader.result);

                        };

                        reader.readAsDataURL(file);

                    }

                }

            });



            function onShowModal() {


                cropper = new Cropper(image, {

                    aspectRatio: 1,

                    viewMode: 4,

                    preview: '.preview',
                    minCropBoxWidth: 100,
                    minCropBoxHeight: 100
                });

                let height = 300;
                let width = 300;
                let canvas = document.getElementById("canvas");
            }


            $("#crop").click(function () {


                // if (typeof canvas === 'undefined') {
                canvas = cropper.getCroppedCanvas({

                    width: 250,

                    height: 250,

                    minCropBoxWidth: 100,//using these just to stop box collapsing on itself
                    minCropBoxHeight: 100,

                });
                // }

                canvas.toBlob(function (blob) {
                    let _token = '<?php echo csrf_token(); ?>'

                    url = URL.createObjectURL(blob);

                    let reader = new FileReader();

                    reader.readAsDataURL(blob);

                    reader.onloadend = function () {

                        let base64data = reader.result;

                        let data = {_token, image: base64data};

                        //      let resp= post("/lk/crop",data);
                        console.log("resp");
                        //  console.log(resp);

                        console.log("ajax");

                        let img = document.getElementById("profile_image").src;
                        console.log("src " + img)

                        $.ajax({

                            type: "POST",
                            // _token: token,

                            dataType: "json",

                            cashe: false,

                            url: "/lk/crop",

                            data,

                            success: function (data) {
                                console.log("cusses");
                                // $modal.modal('hide');

                                document.getElementById("closeUploadModal").click();

                                let url = data.url;

                                let size = data.size;
                                //  let profile_image = document.getElementById("profile_image");
                                //  profile_image.src = url;
                                $("#image2").attr("src", url);

                                //изменяем текст в class="txt" id=txt
                                let txt = document.getElementById("txt");
                                txt.innerText = "/avatarka.jpg (" + size + "Кб)";

                                ///avatarka.jpg (587Кб)
                                $("#profile_image").attr("src", url);

                                //ставим новую картинку как источник

                                cropper.destroy();

                                cropper = null;
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                document.getElementById("closeUploadModal").click();
                                cropper.destroy();

                                cropper = null;
                            }

                        });

                    }

                });

            })
        });
    </script>



@endsection