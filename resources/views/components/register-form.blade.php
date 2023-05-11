<form method="POST" action="{{ route('register') }}" style="width: 350px">
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

    <!--Password confirmation-->
    <div class="mb-4">
        <x-ui.input-label for="password_confirmation" value="Password confirmation" />
        <x-ui.input type="password" id="password_confirmation" name="password_confirmation" required />
        <x-ui.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <!--Button-->
    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">Register</x-ui.button>
    </div>
</form>
