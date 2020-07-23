<div data-remodal-target="upload_img" style="cursor:pointer">
    Загрузить фотографию
</div>

<div class="remodal" data-remodal-id="upload_img" id="modal" role="dialog" aria-labelledby="modal1Title"
     aria-describedby="modal1Desc">

    <div class="web-block_popup">
        <div class="d-flex justify-content-between">
            <div class="web-block_title">Загрузка фото</div>
            <button data-remodal-action="close" class="web-block_close remodal-close"></button>
            <input type='file' id="imgInp" onchange="upload_Image()" style="display: block !important;"/>
            <img id="blah" src="#"/>
        </div>
        <button id="dsds" onclick="upload()">Загрузить</button>
    </div>
    <input type="hidden" id="user_id" value="{{$user->id}}">
    <input type="hidden" id="album_id" value="{{$album->id}}">
</div>
<script type="application/javascript">
    function readURL(input) {
        console.log("readURL");
        input = document.getElementById('imgInp');
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            console.log("no inputs file")
        }
    }

    function upload() {
        console.log("upload");
        let photo = document.getElementById("imgInp").files[0];
        let formData = new FormData();
        formData.append("image", photo);
        //{id}/albums/{albumid}/upload/image
        let user_id = document.getElementById('user_id').value;
        let album_id = document.getElementById('album_id').value;
        formData.append("_token", "{{ csrf_token() }}",);

        fetch(album_id + '/upload/image', {method: "POST", body: formData}).then(function () {
            document.reload();
        }).catch(function () {
          //  Alert("Ошибка. Повторите позже или обратитесь к администратору.")
            document.reload();
        });
    }


    function upload_Image() {
        readURL(this);
    }
</script>