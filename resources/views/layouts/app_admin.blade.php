<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Мадагаскар</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap&subset=cyrillic"
          rel="stylesheet">
    <link rel="shortcut icon" href="/home/favicon.png"/>
    @stack('styles')
    <script>let csrf_token = '{{ csrf_token() }}', $a = [], $$ = a => a && $a.push(a);
		$$.init = () => {
			while ($a.length) ($a.shift())()
		}</script>
</head>
<body class="@yield('body-class')">

@yield('content')

@prepend('scripts')
    <script src="/admins/js/vendor.bundle.base.js"></script>
    <script src="/admins/js/script.js"></script>
    <script src="/admins/js/off-canvas.js"></script>
    <script src="/admins/s/hoverable-collapse.js"></script>
    <script src="/admins/js/template.js"></script>
    <script src="/admins/js/sweetalert.min.js" defer></script>
@endprepend

@stack('scripts')
@stack('js')

<script>
	$(function () {

        {{-- Если передано сообщение success с предыдущего редиректа --}}
        @if (session('success'))
		swal({
			title: '{{ session('success') }}', icon: 'success',
			button: {text: "Continue", value: true, visible: true, className: "btn btn-primary"}
		});
        @endif

        @if (session('error'))
		swal({
			title: '{{ session('error') }}', icon: 'error',
			button: {text: "Continue", value: true, visible: true, className: "btn btn-primary"}
		});
        @endif

        {{-- Запрос на удаление и удаление через метод DELETE --}}
		$('.button-destroy').click(function () {
			let title = 'Вы уверены, что хотите удалить?';
			let text = 'Это действие нельзя будет отменить!';
			if ($(this).data('destroy-title')) title = $(this).data('destroy-title');
			if ($(this).data('destroy-text')) text = $(this).data('destroy-text');
			swal({
				title: title,
				text: text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3f51b5',
				cancelButtonColor: '#ff4081',
				confirmButtonText: 'Great ',
				buttons: {
					cancel: {
						text: "Отмена",
						value: null,
						visible: true,
						className: "btn btn-danger",
						closeModal: true,
					},
					confirm: {
						text: "OK",
						value: true,
						visible: true,
						className: "btn btn-primary",
						closeModal: true
					}
				}
			}).then((result) => {
				let href = $(this).attr('href');
				let id = $(this).attr('id');
				let token = $("meta[name='csrf-token']").attr("content");
				let redirect = $(this).data('redirect');
				if (result) {
					$.ajax({
						url: href,
						type: 'DELETE',
						data: {"id": id, "_token": token},
						success() {
							if (redirect) window.location.href = redirect;
							else window.location.reload();
						}
					});
				}
			});
			return false;
		});

		$('.button-sure').click(function () {
			swal({
				title: 'Вы уверены?',
				text: '',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3f51b5',
				cancelButtonColor: '#ff4081',
				confirmButtonText: 'Great ',
				buttons: {
					cancel: {
						text: "Отмена", value: null, visible: true, className: "btn btn-danger", closeModal: true,
					},
					confirm: {
						text: "OK", value: true, visible: true, className: "btn btn-primary", closeModal: true
					}
				}
			}).then((result) => {
				console.log(result);
				if (result) {
					window.location = $(this).attr('href');
				}
			});
			return false;
		});

        @stack('js')

		$$.init();
	});

</script>

</body>
</html>
