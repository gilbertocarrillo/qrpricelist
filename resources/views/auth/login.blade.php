<x-layouts.app title="Login">
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center bg-light">
        <x-ui.logo width="100" height="100" />
        <div class="lead mb-4 text-center" style="width: 350px">
            Welcome
        </div>
        <x-login-form />
        <div class="text-secondary text-center">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-decoration-none">Sign up</a>
        </div>
    </div>
</x-layouts.app>
