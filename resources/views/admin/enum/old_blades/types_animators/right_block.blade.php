<table class="table table-hover center-aligned-table">
    <thead>
    <tr>
        <th>№</th>
        <th>Наименование</th>
        <th>Актив.</th>
        <th>Цена</th>
        <th colspan="2">Добавлена на площадку</th>
    </tr>
    </thead>
    <tbody>
    @if($selectSite->id != 0)
        @foreach($types_animators_sites as $index => $type_animator_site)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @can('access', 'admin.enum.types_animators_sites.edit')
                        <a class="text-dark font-weight-bold"
                           href="{{ route('admin.enum.types_animators_sites.edit', [$selectSite->id, $type_animator_site->id]) }}">
                            {{ $type_animator_site->title }}
                        </a>
                    @else
                        {{ $type_animator_site->title }}
                    @endcan
                </td>

                <td>
                    @if ($type_animator_site->pivot->active)
                        Активна
                    @else
                        Неактивна
                    @endif
                </td>
                <td>{{ $type_animator_site->pivot->price }} руб.</td>
                <td>{{ \Carbon\Carbon::parse($type_animator_site->pivot->created_at)->format('d.m.Y H:i')}}</td>
                <td>
                    @can('access', 'admin.enum.types_animators_sites.edit')
                        <a href="{{ route('admin.enum.types_animators_sites.edit', [$selectSite->id, $type_animator_site->id]) }}"
                           class="mr-1 text-muted p-2"><i class="mdi mdi-grease-pencil"></i></a>
                    @endcan
                    @can('access', 'admin.enum.types_animators_sites.remove')
                        <a href="{{ route('admin.enum.types_animators_sites.remove', [$selectSite->id, $type_animator_site->id]) }}"
                           data-id="{{ $type_animator_site->id }}"
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