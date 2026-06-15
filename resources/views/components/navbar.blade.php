{{--Pagaidu variants, lai redzētu vai route strāda. Ir jāpārveido.--}}

<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <div class="navbar-nav">
                <a class="nav-link active m-1" aria-current="page">Competitions</a>
                <a class="nav-link m-1">Ranking</a>

                @guest
                    <a class="btn btn-primary m-1" href="{{route('auth.login')}}">Login</a>
                    <a class="btn btn-primary m-1" href="{{route('auth.register')}}">Register</a>
                @endguest

                @auth()
                    <span class="border-2 p-2 m-1">
                            Hi, <strong>{{Auth::user()->name}}</strong>
                        </span>
                    <form action="{{route('logout')}}" method="POST" class="m-1">
                        @csrf
                        <button class="btn btn-danger">Logout</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>
</div>
