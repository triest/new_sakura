<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">

        @php $nn = 0 @endphp
        @foreach(config('app_menu') as $item)
{{--            @can('access', $item['roles'])--}}
                <li class="nav-item">
                    @isset($item['route'])
                        <a class="nav-link" href="{{ route($item['route']) }}">
                            <i class="mdi {{ $item['mdi_icon'] }} menu-icon"></i>
                            <span class="menu-title">{{ $item['title'] }}</span>
                        </a>
                    @endisset
                    @isset($item['items'])
                        <a class="nav-link" data-toggle="collapse" href="#menu-{{ ++$nn }}" aria-expanded="false"
                           aria-controls="ui-basic">
                            <i class="mdi {{ $item['mdi_icon'] }} menu-icon"></i>
                            <span class="menu-title">{{ $item['title'] }}</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="menu-{{ $nn }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach($item['items'] as $sub_item)
{{--                                    @can('access', $sub_item['roles'])--}}
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route($sub_item['route']) }}">
                                                {{ $sub_item['title'] }}
                                            </a>
                                        </li>
{{--                                    @endcan--}}
                                @endforeach
                            </ul>
                        </div>
                    @endisset
                </li>
{{--            @endcan--}}

        @endforeach

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-exit-to-app menu-icon"></i>
                <span class="menu-title">Выход</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                  style="display: none;">@csrf</form>
        </li>

    </ul>
</nav>
