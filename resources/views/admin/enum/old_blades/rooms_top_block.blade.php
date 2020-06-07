@if ($selectSite->id != 0)
    <div class="d-flex align-items-center justify-content-md-end">
        <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
            <p class="text-muted">Всего</p>
            <h6 class="font-weight-medium text-dark mb-0 js-count_rooms">{{ $rooms->count() }}</h6>
        </div>
        @can('access', 'admin.enum.rooms.create')
            <div class="mb-xl-0 ml-4">
                <a type="button" class="btn btn-primary js-a_add_room" href="{{route('admin.enum.rooms.create', $selectSite->id)}}">
                    Добавить комнату
                </a>
            </div>
        @endcan
    </div>
@endif