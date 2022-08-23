<div class="mb-5">
    <nav class="navbar sticky-top navbar-dark bg-primary">
        <div class="container d-flex justify-content-between">
            <div>
                <a href="{{ route('event.index') }}" class="navbar-brand">Event Management</a>
                <a href="{{ route('event.index') }}" class="btn btn-primary ml-2">Homepage</a>
                <a href="{{ route('qoute.index') }}" class="btn btn-primary ml-2">Quote</a>
            </div>

            @auth()
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            @endauth
            @guest
                <div>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>
            @endguest
        </div>
    </nav>

    <div class="container">
        @yield('toolbar')
    </div>
</div>
