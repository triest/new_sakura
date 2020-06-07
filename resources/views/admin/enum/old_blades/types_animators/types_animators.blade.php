@extends('layouts.admin')

@section('title', 'Все костюмы аниматоров')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Все типы анимаций</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: типы анимаций. (<a href="{{ route('admin.enum.types_animators_sites.index') }}">Добавление костюма НА ПЛОЩАДКУ</a>)</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $types_animators->total() }}</h6>
                </div>
                @can('access', 'admin.enum.types_animators.create')
                    <div class="mb-xl-0 ml-4">
                        <a class="btn btn-primary" href="{{ route('admin.enum.types_animators.create') }}">Создать новый костюм</a>
                    </div>
                @endcan
                <div class="mb-xl-0 ml-4 pt-3">
                    {{ $types_animators->links() }}
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
                                <th>Длительность</th>
                                <th>Добавлен</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($types_animators as $index => $type_animator)
                                <tr>
                                    <td>{{ $type_animator->id }}</td>
                                    <td>
                                        @can('access', 'admin.enum.types_animators.edit')
                                            <a class="text-dark font-weight-bold" href="{{ route('admin.enum.types_animators.edit', $type_animator->id) }}">
                                                {{ $type_animator->title }}
                                            </a>
                                        @else
                                            {{ $type_animator->title }}
                                        @endcan
                                    </td>
                                    <td>{{ $type_animator->minutes }} минут.</td>
                                    <td>{{ $type_animator->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @can('access', 'admin.enum.types_animators.edit')
                                            <a href="{{ route('admin.enum.types_animators.edit', $type_animator->id) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                        @can('access', 'admin.enum.types_animators.destroy')
                                            <a href="{{ route('admin.enum.types_animators.destroy', $type_animator->id) }}" data-id="{{ $type_animator->id }}" class="mr-1 text-muted p-2 button-destroy"><i class="mdi mdi-delete"></i></a>
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
