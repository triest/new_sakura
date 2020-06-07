@extends('layouts.admin')

@section('title', 'Все шоу-программы')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Площадки</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Площадки.</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $sites->total() }}</h6>
                </div>
                <div class="mb-xl-0 ml-4 pt-3">
                    {{ $sites->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover center-aligned-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Наименование</th>
                                <th>Активность</th>
                                <th>Кафе на площадке</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sites as $site)
                                <tr>
                                    <td>{{ $site->id }}</td>
                                    <td>
                                        @can('access', 'admin.enum.show_programs.edit')
                                            <a class="text-dark font-weight-bold" href="{{ route('admin.enum.show_programs.edit', $site->id) }}">
                                                {{ $site->city }} - {{ $site->title }}
                                            </a>
                                        @else
                                            {{ $site->city }} - {{ $site->title }}
                                        @endcan
                                    </td>
                                    <td>
                                        @if ($site->status_write == 'active')
                                            <label class="badge badge-success">Активна</label>
                                        @elseif($site->status_write == 'pause')
                                            <label class="badge badge-secondary">Приостановлена</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($site->there_is_cafe == 1)
                                            <label class="badge badge-info">Кафе</label>
                                        @endif
                                    </td>
                                    <td>
                                        @can('access', 'admin.enum.sites.edit')
                                            <a href="{{ route('admin.enum.sites.edit', $site->id) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
