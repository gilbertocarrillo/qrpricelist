@props(['pricelist' => null])

<form method="POST" action="{{ $pricelist ? route('pricelists.update', $pricelist) : route('pricelists.store') }}"
    enctype="multipart/form-data">
    @csrf
    @if ($pricelist)
        @method('PUT')
    @endif

        <div class="h3 lead text-secondary">Business Info</div>
        <div class="row">
            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="name" value="Name" />
                <x-ui.input type="text" id="name" name="name" :value="old('name', $pricelist->name ?? null)" required autofocus />
                <x-ui.input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="currency" value="Currency" />
                <select class="form-select" id="currency" name="currency" value={{ old('currency') }}
                    aria-label="currency">
                    <option value="">-- Select Currency --</option>
                    <option value="USD"
                        {{ old('currency', $pricelist->currency ?? null) == 'USD' ? 'selected' : '' }}>US Dollar
                    </option>
                    <option value="EUR"
                        {{ old('currency', $pricelist->currency ?? null) == 'EUR' ? 'selected' : '' }}>Euro
                    </option>
                    <option value="JPY"
                        {{ old('currency', $pricelist->currency ?? null) == 'JPY' ? 'selected' : '' }}>Japanese Yen
                    </option>
                </select>
                <x-ui.input-error :messages="$errors->get('currency')" class="mt-2" />
            </div>


            <div class="mb-4 col-12">
                <x-ui.input-label for="description" value="Description" />
                <textarea type="textarea" rows="2" id="description" name="description" class="form-control form-control-sm"
                    id="description" style="resize: none;">{{ old('description', $pricelist->description ?? null) }}</textarea>
                <x-ui.input-error :messages="$errors->get('description')" class="mt-2" />
            </div>


            <div class="mb-4 col-12">
                <x-ui.input-label for="address" value="Address" />
                <x-ui.input type="text" id="address" name="address" :value="old('address', $pricelist->address ?? null)" />
                <x-ui.input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="phone" value="Phone" />
                <x-ui.input type="text" id="phone" name="phone" :value="old('phone', $pricelist->phone ?? null)" />
                <x-ui.input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="whatsapp" value="Whatsapp" />
                <x-ui.input type="text" id="whatsapp" name="whatsapp" :value="old('whatsapp', $pricelist->whatsapp ?? null)" />
                <x-ui.input-error :messages="$errors->get('whatsapp')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="logo" value="Logo" />
                <x-ui.input type="file" id="logo" name="logo" />
                <x-ui.input-error :messages="$errors->get('logo')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="cover" value="Cover" />
                <x-ui.input type="file" id="cover" name="cover" />
                <x-ui.input-error :messages="$errors->get('cover')" class="mt-2" />
            </div>

            <div class="h3 lead text-secondary">Social Networks</div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="facebook" value="Facebook" />
                <x-ui.input type="text" id="facebook" name="facebook" :value="old('facebook', $pricelist->facebook ?? null)" />
                <x-ui.input-error :messages="$errors->get('facebook')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="instagram" value="Instragram" />
                <x-ui.input type="text" id="instagram" name="instagram" :value="old('instagram', $pricelist->instagram ?? null)" />
                <x-ui.input-error :messages="$errors->get('instagram')" class="mt-2" />
            </div>

            <div class="mb-4 col-12 col-md-6">
                <x-ui.input-label for="twitter" value="Twitter" />
                <x-ui.input type="text" id="twitter" name="twitter" :value="old('twitter', $pricelist->twitter ?? null)" />
                <x-ui.input-error :messages="$errors->get('twitter')" class="mt-2" />
            </div>
        </div>

        <div class="d-grid mb-4">
            <x-ui.button class="btn-primary">{{ $pricelist ? 'Update' : 'Create' }}</x-ui.button>
        </div>

</form>
