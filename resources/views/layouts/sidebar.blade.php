<nav id="sidebar">
    <br>
    <br>
    <ul class="nav flex-column">

        @foreach ($sidebars as $sidebar)

            @if (is_null($sidebar->parent_id)) 
                @if ($sidebar->admin_access_only && auth()->user()->hasRole('Admin|Super Administrator'))
                    <li class="nav-item">
                        <a href="{{ $sidebar->url ?: '#' }}" class="nav-link text-white @if(request()->is(trim($sidebar->url, '/'))) active @endif" 
                            @if ($sidebar->children->count()) data-toggle="collapse" data-target="#submenu-{{ $sidebar->id }}" aria-expanded="false" @endif>
                            <i class="{{ $sidebar->icon }}"></i> {{ $sidebar->title }}
                            @if ($sidebar->children->count()) <i class="fas fa-chevron-down float-right"></i> @endif
                        </a>
                        @if ($sidebar->children->count())
                            <ul class="collapse" id="submenu-{{ $sidebar->id }}">
                                @foreach ($sidebar->children as $child)
                                    <li class="nav-item">
                                        <a href="{{ $child->url }}" class="nav-link text-white pl-4">{{ $child->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @elseif (!$sidebar->admin_access_only || auth()->user()->hasRole('admin|superadmin'))
                    <!-- Show for all users -->
                    <li class="nav-item">
                        <a href="{{ $sidebar->url ?: '#' }}" class="nav-link text-white @if(request()->is(trim($sidebar->url, '/'))) active @endif" 
                            @if ($sidebar->children->count()) data-toggle="collapse" data-target="#submenu-{{ $sidebar->id }}" aria-expanded="false" @endif>
                            <i class="{{ $sidebar->icon }}"></i> {{ $sidebar->title }}
                            @if ($sidebar->children->count()) <i class="fas fa-chevron-down float-right"></i> @endif
                        </a>
                        @if ($sidebar->children->count())
                            <ul class="collapse" id="submenu-{{ $sidebar->id }}">
                                @foreach ($sidebar->children as $child)
                                    <li class="nav-item">
                                        <a href="{{ $child->url }}" class="nav-link text-white pl-4">{{ $child->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</nav>
