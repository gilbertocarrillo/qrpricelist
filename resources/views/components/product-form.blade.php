@props(['product' => null])

<form method="POST"
    action="{{ $product ? route('products.update', $product->id) : route('pricelists.products.store', Auth::user()->pricelist->id) }}"
    enctype="multipart/form-data">

    @csrf
    @if ($product)
        @method('PUT')
    @endif
    <div class="row">
        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="name" value="Name" />
            <x-ui.input type="text" id="name" name="name" :value="old('name', $product->name ?? null)" required autofocus />
            <x-ui.input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="category_id" value="Category" />
            <select class="form-select" id="category_id" name="category_id" aria-label="category_id">
                <option value="">-- Select a Category --</option>
                @foreach (Auth::user()->pricelist->categories as $category)
                    @if ($category->parent_id == null)
                        <option value="{{ $category->id }}"
                            @if ($product) {{ $category->id == $product->category_id ? 'selected' : '' }} @endif>
                            {{ $category->name }}
                        </option>
                        @if ($category->subcategories)
                            @foreach ($category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                    @if ($product) {{ $subcategory->id == $product->category_id ? 'selected' : '' }} @endif>
                                    ----
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        @endif
                    @endif
                @endforeach

            </select>
            <x-ui.input-error :messages="$errors->get('category_id')" class="mt-2" />
        </div>
    </div>

    <div class="mb-3">
        <x-ui.input-label for="description" value="Description" />
        <textarea type="textarea" rows="2" id="description" name="description" class="form-control form-control-sm"
            id="description" style="resize: none;">{{ old('description', $product->description ?? null) }}</textarea>
        <x-ui.input-error :messages="$errors->get('description')" class="mt-2" />
    </div>
    <div class="row">

        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="price" value="Price" />
            <x-ui.input type="number" id="price" name="price" :value="old('price', $product->price ?? null )"/>
            <x-ui.input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <div class="mb-3 col-12 col-md-6">
            <x-ui.input-label for="photo" value="Photo" />
            <x-ui.input type="file" id="photo" name="photo" />
            <x-ui.input-error :messages="$errors->get('photo')" class="mt-2" />
        </div>
    </div>

    <div class="d-grid mb-4">
        <x-ui.button class="btn-primary">{{ $product ? 'Update' : 'Create' }}</x-ui.button>
    </div>
</form>
