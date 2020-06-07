@push('scripts')

    <script>
        $(function () {
            $('.button-media-delete').click(function () {
                $.post($(this).data('url'), {
                    "_token": $("meta[name='csrf-token']").attr("content")
                }).done(() => {
                    swal({
                        title: 'Фотография удалена',
                        icon: 'info',
                        button: {
                            text: "Закрыть",
                            className: "btn btn-primary"
                        }
                    });
                    $(this).closest('.tiles').remove();
                }).fail(data => {
                    swal({
                        title: data.responseJSON.message,
                        icon: 'warning',
                        button: {
                            text: "Закрыть",
                            className: "btn btn-primary"
                        }
                    });
                });
                return false;
            });

            $('.button-media-cover').click(function () {
                $.post($(this).data('url'), {
                    "_token": $("meta[name='csrf-token']").attr("content")
                }).done(() => {
                    swal({
                        title: 'Фотография назначена главной',
                        icon: 'info',
                        button: {
                            text: "Закрыть",
                            className: "btn btn-primary"
                        }
                    });
                    $(this).closest('.tiles').parent().find('.tiles').removeClass('bg-primary');
                    $(this).closest('.tiles').addClass('bg-primary');
                }).fail(data => {
                    swal({
                        title: data.responseJSON.message,
                        icon: 'warning',
                        button: {
                            text: "Закрыть",
                            className: "btn btn-primary"
                        }
                    });
                });
                return false;
            })
        })
    </script>

@endpush
