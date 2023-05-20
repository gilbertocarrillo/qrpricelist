<x-layouts.app title="Reset password">
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center">
        <x-ui.logo width="100" height="100" />
        <x-register-reset-password-form :request="$request" />
    </div>
</x-layouts.app>
