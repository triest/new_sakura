@if ($selectSite->id != 0)
    <div class="d-flex align-items-center justify-content-md-end">
        <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
            <p class="text-muted">Всего</p>
            <h6 class="font-weight-medium text-dark mb-0">{{ $costumesSite->count() }}</h6>
        </div>
        @can('access', 'admin.enum.costumes_animators_sites.add')
            <div class="mb-xl-0 ml-4">

                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#modelId">
                    Добавить костюм
                </button>

                <!-- Modal -->
                <div class="modal fade" id="modelId" tabindex="-1" role="dialog"
                     aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавить костюм</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @can('access', 'admin.enum.costumes_animators.create')
                                    <a class="btn btn-primary"
                                       href="{{ route('admin.enum.costumes_animators.create') }}">
                                        Добавить новый костюм в общий список</a>
                                @endcan
                                <ul class="list-group mt-3">
                                    @foreach($costumesForAdd as $costumeForAdd)
                                        <li class="list-group-item list-item">
                                            {{ $costumeForAdd->title }}
                                            <a class="btn btn-primary btn-sm float-right"
                                               href="{{ route('admin.enum.costumes_animators_sites.add', [$selectSite->id, $costumeForAdd->id]) }}">
                                                <i class="mdi mdi-plus-box"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    Закрыть
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
@endif