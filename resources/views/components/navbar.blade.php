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
                        <span data-translate="nav_competitions">Competitions</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('rankings.*') ? 'active' : '' }}"
                       href="{{ route('rankings.index') }}">
                        <span data-translate="nav_rankings">Rankings</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pair.*') ? 'active' : '' }}"
                       href="{{ route('pair.index') }}">
                        <span data-translate="nav_pairs">Pairs</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('photo.*') ? 'active' : '' }}"
                       href="{{ route('photo.index') }}">
                        <span data-translate="nav_photos">Photos</span>
                    </a>
                </li>

                {{-- Dropdown with additional pages --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <span data-translate="nav_more">More</span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('handler.index') }}">
                                <span data-translate="nav_handlers">Handlers</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('dog.index') }}">
                                <span data-translate="nav_dogs">Dogs</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('track.index') }}">
                                <span data-translate="nav_tracks">Tracks</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('result.index') }}">
                                <span data-translate="nav_results">Results</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('organizer.index') }}">
                                <span data-translate="nav_organizers">Organizers</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('sponsor.index') }}">
                                <span data-translate="nav_sponsors">Sponsors</span>
                            </a>
                        </li>

                        @auth
                            @if(Auth::user()->isAdmin())
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
                <button class="language-btn active" type="button" data-lang="en">EN</button>
                <button class="language-btn" type="button" data-lang="lv">LV</button>
            </div>

            {{-- Login / Register or user info --}}
            <div class="auth-area">
                @guest
                    <a class="btn btn-primary btn-sm" href="{{ route('auth.login') }}">
                        <span data-translate="nav_login">Login</span>
                    </a>

                    <a class="btn btn-primary btn-sm" href="{{ route('auth.register') }}">
                        <span data-translate="nav_register">Register</span>
                    </a>
                @endguest

                @auth
                    <a href="{{route('profile.edit')}}" class="user-name nav-link">
                        <strong>{{ Auth::user()->name }}</strong>
                    </a>

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
