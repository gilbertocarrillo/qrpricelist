<x-layouts.app title="Forgot password">
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
        <x-ui.logo width="100" height="100" />
        <div class="lead mb-4 text-center" style="width: 350px">
            Let us know your email address and we will email you a password reset link.
        </div>
        <form method="POST" action="{{ route('password.email') }}" style="width: 350px">
            @csrf

            <div class="mb-4">
                <x-ui.input-label for="email" value="Email" />
                <x-ui.input type="email" id="email" name="email" :value="old('email')" required autofocus />
                <x-ui.input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="d-grid mb-4">
                <x-ui.button class="btn-primary">Send Password Reset Link</x-ui.button>
            </div>
        </form>
        <x-ui.back-button class="mb-3" />
</x-layouts.app>
