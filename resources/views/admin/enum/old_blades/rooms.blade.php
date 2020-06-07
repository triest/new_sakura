@extends('layouts.admin')

@section('title', 'Комнаты на площадке')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Комнаты на площадке</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Комнаты на площадке</h6>
        </div>
        <div class="col-sm-8 js-top-rooms-block">
            @include('admin.enum.rooms_top_block')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Доступные площадки
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        @foreach($sites as $site)
                            <li class="nav-item">
                                <a class="nav-link btn text-left js-load_rooms_sites {{ $selectSite->id == $site->id ? 'active' : '' }}"
{{--                                   href="{{ route('admin.enum.rooms.index', $site->id) }}"--}}
                                   data-id_sites="{{ $site->id }}"
                                >
                                    {{ $site->city }} - {{ $site->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <script>
                $$(() => {
	                $(".js-load_rooms_sites").click(function(e) {
	                	e.preventDefault();
		                get('/admin/enum/rooms/ajax_get_room/' + $(this).attr('data-id_sites'))
		                .then(data => {
			                if (! io_res(data)) {
				                return false;
			                }

			                history.pushState(null, null, '/admin/enum/rooms/' + data.id_site);

			                $(".js-load_rooms_sites").removeClass('active');
			                $(this).addClass('active');

			                $(".js-top-rooms-block").html(data.top_block);

			                $(".js-view-rooms").html(data.html);

		                })
		                .catch(error => {
			                swal({
				                type: 'error',
				                title: error,
				                icon: 'error',
				                button: {text: "OK", value: true, visible: true, className: "btn btn-primary"}
			                })
		                })
                    })
                });
            </script>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive js-view-rooms">
                        @include('admin.enum.rooms_right_block')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
