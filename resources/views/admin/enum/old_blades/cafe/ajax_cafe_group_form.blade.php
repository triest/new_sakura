<h3>Редактирование категории</h3>
@component('common.form', [
    'edit' => isset($item->id),
    'action' => isset($item->id) ? route('admin.enum.cafe.group_update', $item->id) : route('admin.enum.cafe.group_store'),
    'media' => true,
    'submit' => 'form_post_submit.call(this); return false;'
])
    <div class="row">
        <div class="col-lg-6">
            @component('common.form.input_text', ['name' => 'title', 'value' => old('title') ?? $item->title]) Наименование @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            @if ($item->getMedia('avatar'))
                <img style="max-height: 150px" src="{{ $item->getFirstMediaUrl('cover') }}" alt="">
            @endif
            @component('common.form.input_gallery', ['name' => 'cover', 'cover' => '']) Добавить Фотографию для категории @endcomponent
        </div>
    </div>
    <button type="button" class="btn btn-primary mr-2 js-send_data-form_group_update">Сохранить</button>
    <a class="btn btn-light js-load-list-dishes" data-id-group="{{$item->id}}">Отмена</a>
    <script>
		$$(() => {
			function form_post_submit() {

				let formData = new FormData();
				formData.append('_method', 'PATCH');
				formData.append('_token', csrf_token);
				formData.append('title', $('[name="title"]', this).val());

				let file_data = $('#coverInput').prop('files')[0];
				if(typeof file_data != 'undefined') {
					formData.append('cover', file_data);
				}

				(new Promise((resolve, reject) => {
					jQuery.ajax({
						url: '{{route('admin.enum.cafe.ajax_group_update', $item->id)}}',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: data => {
							remove_loading_modal();
							if (! io_res(data)) {
								reject(data);
							} else {
								resolve(data);
							}
						},
						error: (jqXHR, textStatus, errorThrown) => {
							let error_obj = {
								jqXHR,
								textStatus,
								errorThrown,
							};

							remove_loading_modal();

							swal({
								title: jqXHR.status + ': ' + errorThrown,
								type: "error",
								timer: 5000,
								cancelButtonText: 'OK!'
							});

							log_to_server('ajax get ' + ln(), error_obj)
							reject(error_obj);
						}
					});
				}))
				.then(data => {
					app_tree.refresh(data.groups);
					// app_tree.tree.jstree(true).settings.core.data = data.groups;
					// app_tree.tree.jstree(true).refresh(true);

					{{--load_list_dishes({{$item->id}});--}}
				})
				.catch(error => {
					console.log(error);
				});

				return false;
			}

			$(".js-send_data-form_group_update").click(function() {
				form_post_submit.call($(this).closest('form'));
			})
		});
		$$.init();
    </script>
@endcomponent

