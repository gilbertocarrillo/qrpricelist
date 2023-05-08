<x-layouts.app title="Home">
    <div class="vh-100">
        {{ Auth::user() }}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                Logout
            </a>
    </div>
</x-layouts.app>
