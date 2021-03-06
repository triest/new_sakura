@extends('layouts.admin')

@section('title', 'Шоу-программы на площадке')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Шоу-программы на площадке</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Шоу-программы на площадке</h6>
        </div>
        <div class="col-sm-8 js-top-show_program-block">
            @include('admin.enum.show_program.top_block')
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
                                <a class="nav-link btn text-left js-load_show_program_sites {{ $selectSite->id == $site->id ? 'active' : '' }}"
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
			        $(".js-load_show_program_sites").click(function(e) {
				        e.preventDefault();
				        get('/admin/enum/ajax_show_programs_sites/' + $(this).attr('data-id_sites'))
				        .then(data => {
					        if (! io_res(data)) {
						        return false;
					        }

					        history.pushState(null, null, '/admin/enum/show_programs_sites/' + data.id_site);

					        // выбранная площадка
					        $(".js-load_show_program_sites").removeClass('active');
					        $(this).addClass('active');


					        $(".js-top-show_program-block").html(data.top_block);

					        $(".js-view-show_program").html(data.html);

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
                    <div class="table-responsive js-view-show_program">
                        @include('admin.enum.show_program.right_block')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
