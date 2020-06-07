@extends('layouts.admin')

@section('title', 'Типы шоу программ на площадке')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Типы шоу программ на площадке</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Типы шоу программ</h6>
        </div>
        <div class="col-sm-8 js-top-block">
            @include('admin.enum.types_show_programs.top_block')
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
                                <a class="nav-link btn text-left js-load_sites {{ $selectSite->id == $site->id ? 'active' : '' }}"
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
					$(".js-load_sites").click(function(e) {
						e.preventDefault();
						get('/admin/enum/ajax_types_show_programs_sites/' + $(this).attr('data-id_sites'))
						.then(data => {
							if (! io_res(data)) {
								return false;
							}

							history.pushState(null, null, '/admin/enum/types_show_program_sites/' + data.id_site);

							// выбранная площадка
							$(".js-load_sites").removeClass('active');
							$(this).addClass('active');


							$(".js-top-block").html(data.top_block);

							$(".js-view-block").html(data.html);

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
                    <div class="table-responsive js-view-block">
                        @include('admin.enum.types_show_programs.right_block')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
