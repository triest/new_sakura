<table class="table table-hover center-aligned-table">
    <thead>
    <tr>
        <th>ID</th>
        <th></th>
        <th>Наименование</th>
        <th>Вместимость (чел.)</th>
        <th colspan="2">Добавлен на площадку</th>
    </tr>
    </thead>
    <tbody>
    @if($selectSite->id != 0)
        @foreach($rooms as $index => $room)
            <tr>
                <td>{{$index + 1}}</td>
                <td>
                    @if($room->cover_media_id)
                        @php
                            $cover = Spatie\MediaLibrary\Models\Media::find($room->cover_media_id)
                        @endphp
                        @if($cover)
                            <img style="min-width: 40px"
                                 src="{{ $cover->getUrl('thumb') }}"
                                 class="img-fluid" alt="">
                        @endif
                    @endif
                </td>
                <td>
                    @can('access', 'admin.enum.rooms.edit')
                        <a class="text-dark font-weight-bold"
                           href="{{ route('admin.enum.rooms.edit',$room->id ) }}">
                            {{$room->title}}
                        </a>
                    @else
                        {{$room->title}}
                    @endcan
                </td>

                <td>{{$room->capacity}} чел.</td>
                <td>{{ \Carbon\Carbon::parse($room->created_at)->format('d.m.Y H:i')}}</td>
                <td>
                    @can('access', 'admin.enum.rooms.edit')
                        <a href="{{ route('admin.enum.rooms.edit', [$room->id]) }}"
                           class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                    @endcan
                    @can('access', 'admin.enum.rooms.destroy')
                        <a href="{{ route('admin.enum.rooms.destroy', [$room->id]) }}"
                           data-id="{{ $room->id }}"
                           class="mr-1 text-muted p-2 button-sure">
                            <i class="mdi mdi-delete"></i>
                        </a>
                    @endcan
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center pt-5 pb-5">Выберите площадку</td>
        </tr>
    @endif
    </tbody>
</table>