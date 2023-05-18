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
                    <table id="categories-table" class="table table-striped responsive align-middle" style="width: 100%">
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
                                        <a class="btn btn-outline-primary btn-sm me-2 mb-2"
                                            href="{{ route('categories.edit', $category->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                <path
                                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                            </svg>
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm mb-2" href="" data-bs-toggle="modal"
                                            data-bs-target="#{{ $modalId }}" data-bs-title="Delete Category"
                                            data-bs-content="Are you sure you want to delete this category? All of its subcategories and products will be also delete them."
                                            data-bs-url="{{ route('categories.destroy', $category->id) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path
                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                <path
                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                            </svg>
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
                                                <a class="btn btn-outline-primary btn-sm me-2 mb-2"
                                                    href="{{ route('categories.edit', $subcategory->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-pen"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                                                    </svg>
                                                </a>
                                                <a class="btn btn-outline-danger btn-sm mb-2" href="#"
                                                    data-bs-toggle="modal" data-bs-target="#{{ $modalId }}"
                                                    data-bs-title="Delete Subcategory"
                                                    data-bs-content="Are you sure you want to delete this subcategory? All of its products will be also delete them."
                                                    data-bs-url="{{ route('categories.destroy', $subcategory->id) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-trash"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z" />
                                                    </svg>
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
                        "order": [],
                        "columnDefs": [{
                                "orderable": false,
                                "targets": [1, 2, 4]
                            },
                            {
                                "width": "150px",
                                "targets": [0,2]
                            },
                            {
                                "width": "100px",
                                "targets": [3,4]
                            },]

                        });
                });
</script>
