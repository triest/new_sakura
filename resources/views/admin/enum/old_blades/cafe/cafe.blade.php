@extends('layouts.admin')

@section('title', 'Справочник кафе')

@push('styles')
    <link rel="stylesheet" href="/css/tree/style.css">
@endpush
@push('scripts')
    <script src="/js/jstree.js"></script>
    <script src="/js/admin/enum/cafe/cafe.js"></script>
@endpush

@section('inner')
    <div class="row mb-4">
        <div class="col-sm-4 mb-xl-0">
            <h3>Справочник кафе</h3>
            <h6 class="font-weight-normal mb-0 text-muted">Справочник: Кафе</h6>
        </div>
        <div class="col-sm-8 js-top_block_cafe">
            @include('admin.enum.cafe.top_block')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Категории блюд
                    <span class="js-button-group-cafe">
                        @can('access', 'admin.enum.cafe.group_create')
                            <a href="{{ route('admin.enum.cafe.group_create') }}"
                               type="button"
                               class="btn btn-primary btn-xs right"
                               style="float: right;"
                               title="Добавить категорию блюд"
                            >
                                <i class="mdi mdi-plus"></i>
                            </a>
                        @endcan
                    </span>
                </div>
                <div class="card-body">
                    <script>
		                let app_tree = false,
			                data_vars = {
				                tree_data_load: <?= json_encode($groups->toArray(), true); ?>
                                @can('access', 'admin.enum.cafe.group_edit')
                                ,access_edit: true
                                @endcan
                                @can('access', 'admin.enum.cafe.group_delete')
				                ,access_del: true
                                @endcan
			                }
		                ;
                    </script>
                    <style>
                        .jstree-edit_node_btn{
                            display: none;
                            padding: 0 6px;
                            height: 25px;
                            border:1px solid #fff;
                            border-radius: 4px;
                        }
                        .jstree-edit_node_btn.edit:hover{
                             border: 1px solid #14ba72;
                             background: #14ba72;
                         }
                        .jstree-edit_node_btn.edit:hover i{
                            color: #fff;
                        }
                        .jstree-edit_node_btn.del:hover{
                            border: 1px solid #ff2f00;
                            background: #ff2f00;
                        }
                        .jstree-edit_node_btn.del:hover i{
                            color: #fff;
                        }
                        .jstree-edit_node_btn:first-child{
                            margin-left: 10px;
                        }
                        .jstree-clicked + span .jstree-edit_node_btn{
                            display: inline-block;
                        }
                    </style>
                    <ul class="nav nav-pills flex-column js-treejs" id="checkTree"></ul>
                </div>

            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body js-cafe-right-block">
                    @include('admin.enum.cafe.right_block')
                </div>
            </div>
        </div>
    </div>
@endsection
