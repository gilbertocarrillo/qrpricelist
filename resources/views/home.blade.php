<x-layouts.app title="Home">
    <div class="lead">
        Home
    </div>

    <div>
        {{ Auth::user() }}
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a class="link" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                        this.closest('form').submit();">
            Logout
        </a>
    </form>

</x-layouts.app>
