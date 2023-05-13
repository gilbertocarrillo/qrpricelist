@props(['category' => null, 'pricelist' => null])

<form method="POST"
    action="{{ $category ? route('categories.update', $category->id) : ($pricelist ? route('pricelists.categories.store', $pricelist->id) : '#') }}">
    @csrf
    @if ($category)
        @method('PUT')
    @endif
    <div class="row">
        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="name" value="Name" />
            <x-ui.input type="text" id="name" name="name" :value="old('name', $category->name ?? null)" required autofocus />
            <x-ui.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="parent_id" value="Parent Category" />
            <select class="form-select" id="parent_id" name="parent_id" aria-label="parent_id"
                {{ $category && $category->parent_id == null ? 'disabled' : '' }}>
                <option value="">-- Parent category --</option>

                @if ($pricelist)
                    @foreach ($pricelist->categories()->where('parent_id', null)->get() as $ct)
                        <option value="{{ $ct->id }}">
                            {{ $ct->name }}
                        </option>
                    @endforeach
                @endif

                @if ($category)
                    @foreach ($category->pricelist->categories()->where('parent_id', null)->get() as $ct)
                        <option value="{{ $ct->id }}"
                            {{ $category->parent_id == $ct->id ? 'selected' : '' }}>
                            {{ $ct->name }}
                        </option>
                    @endforeach
                @endif
            </select>
            <x-ui.input-error :messages="$errors->get('parent_id')" class="mt-2" />
        </div>
    </div>

    <div class="mb-3">
        <x-ui.input-label for="description" value="Description" />
        <textarea type="textarea" rows="2" id="description" name="description" class="form-control form-control-sm"
            id="description" style="resize: none;">{{ old('description', $category->description ?? null) }}</textarea>
        <x-ui.input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">{{ $category ? 'Update' : 'Create' }}</x-ui.button>
    </div>
</form>
