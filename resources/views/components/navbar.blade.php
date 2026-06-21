{{-- Main navigation menu --}}

<nav class="navbar navbar-expand-lg navbar-light site-navbar sticky-top">
    <div class="container">

        {{-- Website name --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            Agility Latvia
        </a>

        {{-- Button for mobile menu --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu links --}}
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('competition.*') ? 'active' : '' }}"
                       href="{{ route('competition.index') }}">
                        Competitions
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rankings.*') ? 'active' : '' }}"
                       href="{{ route('rankings.index') }}">
                        Rankings
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pair.*') ? 'active' : '' }}"
                       href="{{ route('pair.index') }}">
                        Pairs
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('photo.*') ? 'active' : '' }}"
                       href="{{ route('photo.index') }}">
                        Photos
                    </a>
                </li>

                {{-- Dropdown with additional pages --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        More
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('handler.index') }}">Handlers</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dog.index') }}">Dogs</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('track.index') }}">Tracks</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('result.index') }}">Results</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('organizer.index') }}">Organizers</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('sponsor.index') }}">Sponsors</a>
                        </li>

                        @auth
                            @if(Auth::user()->isAdmin())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        User management
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </li>
            </ul>

            {{-- Language switch buttons --}}
            <div class="language-switch">
                <button class="language-btn active" type="button">EN</button>
                <button class="language-btn" type="button">LV</button>
            </div>

            {{-- Login / Register or user info --}}
            <div class="auth-area">
                @guest
                   <a class="btn btn-primary btn-sm" href="{{ route('auth.login') }}">
                        Login
                    </a>

                    <a class="btn btn-primary btn-sm" href="{{ route('auth.register') }}">
                        Register
                    </a>
                @endguest

                @auth
                    <span class="user-name">
                        Hi, <strong>{{ Auth::user()->name }}</strong>
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
</nav>