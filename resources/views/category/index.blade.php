@php
    $deleteUrl = route('categories.destroy', ':id');
    $modalId = 'deleteCategoryModal';
@endphp

<x-layouts.app title="Categories">
    <x-layouts.dashboard>
        @if ($pricelist->categories->isEmpty())
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="fs-4 text-secondary mb-2">
                    Category not found
                </div>

                <a href="{{ route('pricelists.categories.create', $pricelist->id) }}" class="btn btn-primary">
                    Create a Category
                </a>
            </div>
        @else
            <a href="{{ route('pricelists.categories.create', $pricelist->id) }}" class="btn btn-primary mb-2">
                Create a Category
            </a>
            <ul class="list-group">
                @foreach ($pricelist->categories->where('parent_id', null) as $category)
                    <li class="list-group-item list-group-item-primary mb-3 rounded">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-1">
                                {{ $category->name }}
                            </h5>
                            <div>
                                <x-ui.actions-button :modalId="$modalId" title="Delete category"
                                    content="Are you sure you want to delete this category? All of its subcategories and products will be also delete them."
                                    :edit-url="route('categories.edit', $category->id)" :delete-url="route('categories.destroy', $category->id)" />
                            </div>

                        </div>
                        <p>
                            {{ $category->description }}
                        </p>

                        @if ($category->subcategories)
                            <ul class="list-group">
                                @foreach ($category->subcategories as $subcategory)
                                    <li class="list-group-item list-group-item-light mb-2 rounded">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-1 me-2">
                                                {{ $subcategory->name }}
                                            </h5>
                                            <div>
                                                <x-ui.actions-button :modalId="$modalId" title="Delete Subcategory"
                                                    content="Are you sure you want to delete this subcategory? All of its products will be also delete them."
                                                    :edit-url="route('categories.edit', $subcategory->id)" :delete-url="route('categories.destroy', $subcategory->id)" />
                                            </div>
                                        </div>
                                        <p>
                                            {{ $subcategory->description }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif

        <x-ui.modal-delete :id="$modalId" />

    </x-layouts.dashboard>
</x-layouts.app>
