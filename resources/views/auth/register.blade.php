<x-layouts.app title="Register">
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
        <x-ui.logo width="100" height="100" />
        <div class="lead mb-4 text-center" style="width: 350px">
            Sign up and start to share your pricelist with everyone
        </div>
        <x-register-form />
        <div class="text-secondary text-center">
            Do you have an account?
            <a href="{{ route('login') }}"class="text-decoration-none">Sign in</a>
        </div>
    </div>
</x-layouts.app>
