<div class="d-flex align-items-center justify-content-md-end">
    @if ($selectGroup->id != 0)
        <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
            <p class="text-muted">Всего</p>
            <h6 class="font-weight-medium text-dark mb-0">{{ $selectGroup->dishes->count() }}</h6>
        </div>
    @endif
    @can('access', 'admin.enum.cafe.dish_create')
        <div class="mb-xl-0 ml-4">
            @if ($selectGroup->id != 0)
                @can('access', 'admin.enum.cafe.dish_create')
                    <a href="{{ route('admin.enum.cafe.dish_create', $selectGroup->id) }}" type="button" class="btn btn-primary">
                        Добавить блюдо
                    </a>
                @endcan
            @endif
        </div>
    @endcan
</div>