<nav class="navbar navbar-expand-lg navbar-light site-navbar sticky-top">
    <div class="container">

        <a class="navbar-brand" href="{{ url('/') }}">
            {{ __('navigation.agility_latvia') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('competition.*') ? 'active' : '' }}"
                       href="{{ route('competition.index') }}">
                        {{ __('navigation.competitions') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rankings.*') ? 'active' : '' }}"
                       href="{{ route('rankings.index') }}">
                        {{ __('navigation.rankings') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pair.*') ? 'active' : '' }}"
                       href="{{ route('pair.index') }}">
                        {{ __('navigation.pairs') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('photo.*') ? 'active' : '' }}"
                       href="{{ route('photo.index') }}">
                        {{ __('navigation.photos') }}
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ __('navigation.more') }}
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('handler.index') }}">
                                {{ __('navigation.handlers') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('dog.index') }}">
                                {{ __('navigation.dogs') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('track.index') }}">
                                {{ __('navigation.tracks') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('result.index') }}">
                                {{ __('navigation.results') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('organizer.index') }}">
                                {{ __('navigation.organizers') }}
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('sponsor.index') }}">
                                {{ __('navigation.sponsors') }}
                            </a>
                        </li>

                        @auth
                            @if(Auth::user()->isAdmin())
                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        {{ __('navigation.user_management') }}
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </li>
            </ul>

            <div class="language-switch">
                <a href="{{ route('language.switch', 'en') }}"
                   class="btn btn-sm {{ app()->getLocale() === 'en' ? 'btn-primary' : 'btn-outline-primary' }}">
                    EN
                </a>

                <a href="{{ route('language.switch', 'lv') }}"
                   class="btn btn-sm {{ app()->getLocale() === 'lv' ? 'btn-primary' : 'btn-outline-primary' }}">
                    LV
                </a>
            </div>

            <div class="auth-area">
                @guest
                    <a class="btn btn-primary btn-sm" href="{{ route('auth.login') }}">
                        {{ __('navigation.login') }}
                    </a>

                    <a class="btn btn-primary btn-sm" href="{{ route('auth.register') }}">
                        {{ __('navigation.register') }}
                    </a>
                @endguest

                @auth
                    <a href="{{ route('profile.edit') }}" class="user-name nav-link">
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button class="btn btn-outline-danger btn-sm">
                            {{ __('navigation.logout') }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>
