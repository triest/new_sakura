<table class="table table-hover center-aligned-table">
    <thead>
    <tr>
        <th>№</th>
        <th></th>
        <th>Наименование</th>
        <th>Кол-во</th>
        <th>Актив.</th>
        <th colspan="2">Добавлен на площадку</th>
    </tr>
    </thead>
    <tbody>
    @if($selectSite->id != 0)
        @foreach($costumesSite as $index => $costumeSite)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($costumeSite->pivot->cover_media_id)
                        @php
                            $cover = Spatie\MediaLibrary\Models\Media::find($costumeSite->pivot->cover_media_id)
                        @endphp
                        @if($cover)
                            <img style="min-width: 40px"
                                 src="{{ $cover->getUrl('thumb') }}"
                                 class="img-fluid" alt="">
                        @endif
                    @endif
                </td>
                <td>
                    @can('access', 'admin.enum.costumes_animators_sites.edit')
                        <a class="text-dark font-weight-bold"
                           href="{{ route('admin.enum.costumes_animators_sites.edit', [$selectSite->id, $costumeSite->id]) }}">
                            {{$costumeSite->title }}
                        </a>
                    @else
                        {{ $costumeSite->title }}
                    @endcan
                </td>

                <td>{{$costumeSite->pivot->count}}</td>
                <td>
                    @if ($costumeSite->active)
                        Активен
                    @else
                        Неактивен
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($costumeSite->pivot->created_at)->format('d.m.Y H:i')}}</td>
                <td>
                    @can('access', 'admin.enum.costumes_animators_sites.edit')
                        <a href="{{ route('admin.enum.costumes_animators_sites.edit', [$selectSite->id, $costumeSite->id]) }}"
                           class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                    @endcan
                    @can('access', 'admin.enum.costumes_animators_sites.remove')
                        <a href="{{ route('admin.enum.costumes_animators_sites.remove', [$selectSite->id, $costumeSite->id]) }}"
                           data-id="{{ $costumeSite->id }}"
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