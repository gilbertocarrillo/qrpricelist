<form method="POST" action="{{ route('profile.update') }}" style="width: 350px">
    @csrf
    @method('patch')

    <div class="mb-4">
        <x-ui.input-label for="email" value="Email" />
        <x-ui.input type="email" id="email" name="email" :value="old('email', Auth::user()->email)" required />
        <x-ui.input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">Save</x-ui.button>
    </div>
</form>
