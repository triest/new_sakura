<div class="table-responsive">
    <table class="table table-hover center-aligned-table">
        <thead>
        <tr>
            <th>№</th>
            <th>Фото</th>
            <th>Наименование</th>
        </tr>
        </thead>
        <tbody>
        @if($selectGroup->id != 0)
            @foreach($selectGroup->dishes as $index => $dish)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($dish->cover_media_id)
                            @php
                                $cover = Spatie\MediaLibrary\Models\Media::find($dish->cover_media_id)
                            @endphp
                            @if($cover)
                                <img style="min-width: 40px" src="{{ $cover->getUrl('thumb') }}" class="img-fluid" alt="">
                            @endif
                        @endif
                    </td>
                    <td>
                        @can('access', 'admin.enum.cafe.dish_edit')
                            <a class="text-dark font-weight-bold" href="{{ route('admin.enum.cafe.dish_edit', [$dish->id]) }}">
                                {{ $dish->title }}
                            </a>
                        @else
                            {{ $dish->title }}
                        @endcan
                    </td>
                    {{--                <td>{{ \Carbon\Carbon::parse($dish->created_at)->format('d.m.Y')}}</td>--}}
                    <td>
                        @can('access', 'admin.enum.cafe.dish_edit')
                            <a href="{{ route('admin.enum.cafe.dish_edit', [$dish->id]) }}" class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                        @endcan
                        @can('access', 'admin.enum.cafe.dish_delete')
                            <a href="{{ route('admin.enum.cafe.dish_delete', [$dish->id]) }}" data-id="{{ $dish->id }}" class="mr-1 text-muted p-2 button-sure">
                                <i class="mdi mdi-delete"></i> </a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7" class="text-center pt-5 pb-5">Выберите категорию блюд</td>
            </tr>
        @endif
        </tbody>
        <script>
            var auto_select_node_jstree = '{{$selectGroup->id}}';
        </script>
    </table>
</div>