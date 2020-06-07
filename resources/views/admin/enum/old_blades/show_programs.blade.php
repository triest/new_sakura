@extends('layouts.admin')

@section('title', 'Все шоу-программы')

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Все шоу-программы</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Все шоу-программы. (<a href="{{ route('admin.enum.show_programs_sites.index') }}">Добавление шоу-программы НА ПЛОЩАДКУ</a>)</h6>
        </div>
        <div class="col-sm-8">
            <div class="d-flex align-items-center justify-content-md-end">
                <div class="border-right-dark pr-4 mb-xl-0 d-xl-block d-none">
                    <p class="text-muted">Всего</p>
                    <h6 class="font-weight-medium text-dark mb-0">{{ $showPrograms->total() }}</h6>
                </div>
                @can('access', 'admin.enum.show_programs.create')
                <div class="mb-xl-0 ml-4">
                    <a class="btn btn-primary" href="{{ route('admin.enum.show_programs.create') }}">Создать новую шоу-программу</a>
                </div>
                @endcan
                <div class="mb-xl-0 ml-4 pt-3">
                    {{ $showPrograms->links() }}
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
                                <th>Добавлена</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($showPrograms as $show_program)
                                <tr>
                                    <td>{{ $show_program->id }}</td>
                                    <td>
                                        @can('access', 'admin.enum.show_programs.edit')
                                            <a class="text-dark font-weight-bold" href="{{ route('admin.enum.show_programs.edit', $show_program->id) }}">
                                                {{ $show_program->title }}
                                            </a>
                                        @else
                                            {{ $show_program->title }}
                                        @endcan
                                    </td>
                                    <td>
                                        @if ($show_program->active)
                                            <label class="badge badge-success">Активна</label>
                                        @else
                                            <label class="badge badge-warning">Неактивна</label>
                                        @endif
                                    </td>
                                    <td>{{ $show_program->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @can('access', 'admin.enum.show_programs.edit')
                                            <a href="{{ route('admin.enum.show_programs.edit', $show_program->id) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                                        @endcan
                                        @can('access', 'admin.enum.show_programs.destroy')
                                            <a href="{{ route('admin.enum.show_programs.destroy', $show_program->id) }}" data-id="{{ $show_program->id }}" class="mr-1 text-muted p-2 button-destroy"><i class="mdi mdi-delete"></i></a>
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
