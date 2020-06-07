<table class="table table-hover center-aligned-table">
    <thead>
    <tr>
        <th>№</th>
        <th></th>
        <th>Наименование</th>
        <th>Кол-во</th>
        <th>Актив.</th>
        <th colspan="2">Добавлена на площадку</th>
    </tr>
    </thead>
    <tbody>
    @if($selectSite->id != 0)
        @foreach($showProgramsSite as $index => $showProgramSite)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($showProgramSite->pivot->cover_media_id)
                        @php
                            $cover = Spatie\MediaLibrary\Models\Media::find($showProgramSite->pivot->cover_media_id)
                        @endphp
                        @if($cover)
                            <img style="min-width: 40px"
                                 src="{{ $cover->getUrl('thumb') }}"
                                 class="img-fluid" alt="">
                        @endif
                    @endif
                </td>
                <td>
                    @can('access', 'admin.enum.show_programs_sites.edit')
                        <a class="text-dark font-weight-bold"
                           href="{{ route('admin.enum.show_programs_sites.edit', [$selectSite->id, $showProgramSite->id]) }}">
                            {{$showProgramSite->title }}
                        </a>
                    @else
                        {{ $showProgramSite->title }}
                    @endcan
                </td>

                <td>{{$showProgramSite->pivot->count}}</td>
                <td>
                    @if ($showProgramSite->active)
                        Активна
                    @else
                        Неактивна
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($showProgramSite->pivot->created_at)->format('d.m.Y H:i')}}</td>
                <td>
                    @can('access', 'admin.enum.show_programs_sites.edit')
                        <a href="{{ route('admin.enum.show_programs_sites.edit', [$selectSite->id, $showProgramSite->id]) }}"
                           class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                    @endcan
                    @can('access', 'admin.enum.show_programs_sites.remove')
                        <a href="{{ route('admin.enum.show_programs_sites.remove', [$selectSite->id, $showProgramSite->id]) }}"
                           data-id="{{ $showProgramSite->id }}"
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