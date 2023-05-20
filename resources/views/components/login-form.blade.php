<form method="POST" action="{{ route('login') }}" style="width: 350px">
    @csrf

    <!--Email-->
    <div class="mb-4">
        <x-ui.input-label for="email" value="Email" />
        <x-ui.input type="email" id="email" name="email" :value="old('email')" required autofocus />
        <x-ui.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!--Password-->
    <div class="mb-4">
        <x-ui.input-label for="password" value="Password" />
        <x-ui.input type="password" id="password" name="password" required />
        <x-ui.input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!--Check-->
    <div class="mb-4 d-flex justify-content-between">
        <div class="form-check">
            <label for="remember" class="form-check-label">Remember me</label>
            <input type="checkbox" id="remember" name="remember" class="form-check-input">
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot password?</a>
        @endif
    </div>

    <!--Button-->
    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">Sing in</x-ui.button>
    </div>
</form>
