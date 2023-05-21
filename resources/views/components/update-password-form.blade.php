<form method="POST" action="{{ route('password.update') }}" style="width: 350px">
    @csrf
    @method('put')
    <div class="mb-4">
        <x-ui.input-label for="current_password" value="Current Password" />
        <x-ui.input type="password" id="current_password" name="current_password" required />
        <x-ui.input-error :messages="$errors->get('current_password')" class="mt-2" />
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
        <x-ui.button class="btn-primary">Save</x-ui.button>
    </div>
</form>
