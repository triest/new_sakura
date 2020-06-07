<!DOCTYPE html>

<html>

<head>

    <title>Laravel Crop Image Before Upload using Cropper JS</title>

    <meta name="_token" content="{{ csrf_token() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"
            integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css"
          crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"
            integrity="sha256-WqU1JavFxSAMcLP2WIOI+GB2zWmShMI82mTpLDcqFUg=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
          integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
            integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

</head>


<body>
<style type="text/css">

    img {

        display: block;

        max-width: 100%;

    }

    .preview {

        overflow: hidden;

        width: 160px;

        height: 160px;

        margin: 10px;

        border: 1px solid red;

        border-radius: 50%;
    }

    .cropper-crop-box, .cropper-view-box {
        border-radius: 50%;
    }

    .cropper-crop-box {
        min-width: 100px !important;
        min-height: 100px !important;
    }

    .preview {
        box-shadow: 0 0 0 1px #39f;
        outline: 0;
        min-width: 100px !important;
        min-height: 100px !important;
    }

    .modal-lg {

        max-width: 1000px !important;

    }

</style>

<div class="container">

    <h1>Laravel Crop Image Before Upload using Cropper JS - NiceSnippets.com</h1>

    <input type="file" name="image" class="image">

</div>


<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="modalLabel">Laravel Crop Image Before Upload using Cropper JS -
                    NiceSnippets.com</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">×</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="img-container">

                    <div class="row">

                        <div class="col-md-5">

                            <img id="image2" src="https://avatars0.githubusercontent.com/u/3456749">

                        </div>

                        <div class="col-md-4">

                            <div class="preview"></div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-primary" id="crop">Crop</button>

            </div>

        </div>

    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">


</div>

<script>


    var $modal = $('#modal');

    var image = document.getElementById('image2');

    var cropper;


    $("body").on("change", ".image", function (e) {

        var files = e.target.files;

        var done = function (url) {

            image.src = url;

            $modal.modal('show');

        };

        var reader;

        var file;

        var url;


        if (files && files.length > 0) {

            file = files[0];


            if (URL) {

                done(URL.createObjectURL(file));

            } else if (FileReader) {

                reader = new FileReader();

                reader.onload = function (e) {

                    done(reader.result);

                };

                reader.readAsDataURL(file);

            }

        }

    });


    $modal.on('shown.bs.modal', function () {

        cropper = new Cropper(image, {

            aspectRatio: 1,

            viewMode: 4,

            preview: '.preview',
            minCropBoxWidth: 100,
            minCropBoxHeight: 100
        })
        ;
        let height = 300;
        let width = 300;
        let canvas = document.getElementById("canvas");

        /*   let context = canvas.getContext('2d');
           context.imageSmoothingEnabled = true;
           context.drawImage(sourceCanvas, 0, 0, width, height, 0, 0, 320, 320);
           context.globalCompositeOperation = 'destination-in';
           context.beginPath();
           console.log(height);
           console.log(width);
           context.ellipse(width / 2, height / 2, width / 2, height / 2, 45 * 3.14, 0, 45 * 3.14);
           context.fill();
   */
    }).on('hidden.bs.modal', function () {

        cropper.destroy();

        cropper = null;

    });


    $("#crop").click(function () {

        canvas = cropper.getCroppedCanvas({

            width: 250,

            height: 250,

            minCropBoxWidth: 100,//using these just to stop box collapsing on itself
            minCropBoxHeight: 100,

        });


        canvas.toBlob(function (blob) {
            let token = '<?php echo csrf_token(); ?>'

            url = URL.createObjectURL(blob);

            var reader = new FileReader();

            reader.readAsDataURL(blob);

            reader.onloadend = function () {

                var base64data = reader.result;


                $.ajax({

                    type: "POST",
                    _token: token,

                    dataType: "json",

                    url: "/lk/crop",

                    data: {'_token': $('meta[name="_token"]').attr('content'), 'image': base64data},

                    success: function (data) {

                        $modal.modal('hide');

                        alert("success upload image");

                    }

                });

            }

        });

    })


</script>

</body>

</html> 