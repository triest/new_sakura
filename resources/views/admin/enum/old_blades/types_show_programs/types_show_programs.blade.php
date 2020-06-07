@extends('layouts.admin')

@section('title', 'Типы шоу программ')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Все типы шоу программ</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: шоу программы. (<a href="{{ route('admin.enum.types_show_programs_sites.index') }}">Добавление тип шоу программы на площадку</a>)</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $types_show_programs->total() }}</h6>
                </div>
                @can('access', 'admin.enum.types_show_programs.create')
                    <div class="mb-xl-0 ml-4">
                        <a class="btn btn-primary" href="{{ route('admin.enum.types_show_programs.create') }}">Создать новый тип шоу программы</a>
                    </div>
                @endcan
                <div class="mb-xl-0 ml-4 pt-3">
                    {{ $types_show_programs->links() }}
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
                            @foreach($types_show_programs as $index => $type_show_program)
                                <tr>
                                    <td>{{ $type_show_program->id }}</td>
                                    <td>
                                        @can('access', 'admin.enum.types_show_programs.edit')
                                            <a class="text-dark font-weight-bold"
                                               href="{{ route('admin.enum.types_show_programs.edit', $type_show_program->id) }}">
                                                {{ $type_show_program->title }}
                                            </a>
                                        @else
                                            {{ $type_show_program->title }}
                                        @endcan
                                    </td>
                                    <td>{{ $type_show_program->minutes }} минут.</td>
                                    <td>{{ $type_show_program->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @can('access', 'admin.enum.types_show_programs.edit')
                                            <a href="{{ route('admin.enum.types_show_programs.edit', $type_show_program->id) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                        @can('access', 'admin.enum.types_show_programs.destroy')
                                            <a href="{{ route('admin.enum.types_show_programs.destroy', $type_show_program->id) }}" data-id="{{ $type_show_program->id }}" class="mr-1 text-muted p-2 button-destroy"><i class="mdi mdi-delete"></i></a>
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
