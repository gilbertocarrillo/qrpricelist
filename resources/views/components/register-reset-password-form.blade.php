@props(['request' => null])
<form method="POST" action="{{ $request ? route('password.store') : route('register') }}" style="width: 350px">
    @csrf

    @if ($request)
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
    @endif

    <div class="mb-4">
        <x-ui.input-label for="email" value="Email" />
        <x-ui.input type="email" id="email" name="email" :value="old('email', $request ? $request->email : null)" required autofocus />
        <x-ui.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-ui.input-label for="password" value="Password" />
        <x-ui.input type="password" id="password" name="password" required />
        <x-ui.input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="mb-4">
        <x-ui.input-label for="password_confirmation" value="Password confirmation" />
        <x-ui.input type="password" id="password_confirmation" name="password_confirmation" required />
        <x-ui.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">{{ $request ? 'Reset password' : 'Register' }}</x-ui.button>
    </div>
</form>
