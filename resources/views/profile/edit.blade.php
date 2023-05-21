<x-layouts.app title="Edit profile">
    <x-layouts.dashboard>
        <div class="d-flex flex-column align-items-center w-100 h-100">
            <div class="h3 lead text-secondary mb-3">Update your account's email address</div>
            <x-profile-email-form />

            <div class="h3 lead text-secondary mb-3">Update your password</div>
            <x-update-password-form />

            <div class="h3 lead text-secondary mb-3 text-danger">Delete account</div>
            <div class="fw-light text-danger mb-3" style="width: 350px">
                Once your account is deleted, all of its
                resources and data will be permanently deleted.
            </div>
            <form method="POST" action={{ route('profile.destroy') }}>
                @csrf
                @method('DELETE')
                <div class="input-group mb-3">
                    <x-ui.input placeholder="Password" type="password" id="password_delete" name="password" required />
                    <x-ui.button class="btn-outline-danger">Delete</x-ui.-button>
                </div>
                <x-ui.input-error :messages="$errors->deleteProfile->get('password')" class="mt-2" />
            </form>
        </div>
    </x-layouts.dashboard>
</x-layouts.app>
