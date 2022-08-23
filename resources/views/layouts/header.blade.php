<div class="mb-5">
    <nav class="navbar sticky-top navbar-dark bg-primary">
        <div class="container d-flex justify-content-between">
            <div>
                <a href="{{ route('event.index') }}" class="navbar-brand">Event Management</a>
            </div>

            @auth()
                <div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <div class="container">
        @yield('toolbar')
    </div>
</div>
