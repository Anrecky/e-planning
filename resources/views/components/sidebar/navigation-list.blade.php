@foreach ($menuItems as $menu)
    @php
        $hasChildren = !empty($menu['children']);
        $hrefUrl = $hasChildren ? '#' . Str::snake($menu['title'], '-') : $menu['url'];
        $depth = $menu['depth'];

        $liClass = '';
        if ($depth === 0) {
            $liClass = 'menu';
        } elseif ($depth === 1) {
            $liClass = 'submenu';
        }

        $aClass = '';
        if ((!$hasChildren && $depth === 0) || $depth === 1) {
            $aClass = 'dropdown-toggle';
        } elseif ($hasChildren && $depth !== 2) {
            $aClass = 'dropdown-toggle';
        } else {
            $aClass = 'ssubmenu';
        }

        $ulClass = '';
        if ($depth === 0) {
            $ulClass = 'submenu';
        } else {
            $ulClass = 'sub-submenu';
        }

    @endphp
    <li class="{{ $liClass }} {{ $menu['active'] && $depth !== 1 ? 'active' : '' }}">
        <a href="{{ $hrefUrl }}" @if ($hasChildren) data-bs-toggle="collapse" @endif
            aria-expanded="{{ $menu['active'] ? 'true' : 'false' }}"
            class="{{ $aClass }} {{ $menu['active'] ? 'collapsed' : '' }}">
            <div class="" style="display: flex;gap:2px !important;">
                @if ($depth == 1)
                    <i class="feather-24 active" style="flex-grow:1 !important;" data-feather="folder"></i>
                @elseif($depth == 2)
                    <i class="feather-24 active" style="flex-grow:1 !important;" data-feather="file"></i>
                @endif
                <span style="text-wrap:wrap;flex-grow:0 !important;flex-shrink:4"
                    class="fw-bold icon-name  @if ($depth == 1)  @endif">
                    {{ Str::upper($menu['title']) }}</span>
            </div>
            @if ($hasChildren)
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
            @endif
        </a>

        @if ($hasChildren)
            <ul class="collapse {{ $ulClass }} list-unstyled {{ $menu['active'] ? 'show' : '' }} "
                id="{{ Str::snake($menu['title'], '-') }}"
                data-bs-parent="{{ $depth === 0 ? '#accordionExample' : Str::snake($menu['title'], '-') }}">
                <x-sidebar.navigation-list :menuItems="$menu['children']" />
            </ul>
        @endif
    </li>
@endforeach
