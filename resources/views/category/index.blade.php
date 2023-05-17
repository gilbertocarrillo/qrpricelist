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
            <div class="card w-100">
                <div class="card-body">
                    <table id="categories-table" class="table table-striped responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Parent category</th>
                                <th># Products</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pricelist->categories->where('parent_id', null) as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td> --- </td>
                                    <td>{{ count($category->products) }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm me-2"
                                            href="{{ route('categories.edit', $category->id) }}">
                                            Edit
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm" href="" data-bs-toggle="modal"
                                            data-bs-target="#{{ $modalId }}" data-bs-title="Delete Category"
                                            data-bs-content="Are you sure you want to delete this category? All of its subcategories and products will be also delete them."
                                            data-bs-url="{{ route('categories.destroy', $category->id) }}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                @if ($category->subcategories)
                                    @foreach ($category->subcategories as $subcategory)
                                        <tr>
                                            <td>{{ $subcategory->name }}</td>
                                            <td>{{ $subcategory->description }}</td>
                                            <td>{{ $subcategory->parent->name }}</td>
                                            <td>{{ count($subcategory->products) }}</td>
                                            <td>
                                                <a class="btn btn-outline-primary btn-sm me-2"
                                                    href="{{ route('categories.edit', $subcategory->id) }}">
                                                    Edit
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm" href=""
                                                    data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"
                                                    data-bs-title="Delete Subcategory"
                                                    data-bs-content="Are you sure you want to delete this subcategory? All of its products will be also delete them."
                                                    data-bs-url="{{ route('categories.destroy', $subcategory->id) }}">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                    </table>
        @endif
        <x-ui.modal-delete :id="$modalId" />
    </x-layouts.dashboard>
</x-layouts.app>
<script>
    $(document).ready(function() {
        $('#categories-table').DataTable({
            info: false,
            responsive: true,
            "lengthChange": false,
            "pageLength": 15,
            "order":[],
            "columnDefs": [{
                "orderable" :false,
                "targets": [1,2,4]
            }],
        });
    });
</script>
