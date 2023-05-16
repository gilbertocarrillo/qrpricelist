@php
    $deleteUrl = route('products.destroy', ':id');
@endphp
<x-layouts.app title="Products">
    <x-layouts.dashboard>
        @if (Auth::user()->pricelist->categories->isEmpty())
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="fs-4 text-secondary mb-2">
                    Category not found
                </div>

                <a href="{{ route('pricelists.categories.create', Auth::user()->pricelist->id) }}"
                    class="btn btn-primary">
                    Create a Category
                </a>
            </div>
        @elseif ($products->isEmpty())
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="fs-4 text-secondary mb-2">
                    Products not found
                </div>

                <a href="{{ route('pricelists.products.create', Auth::user()->pricelist->id) }}" class="btn btn-primary">
                    Create a Product
                </a>
            </div>
        @else
            <a href="{{ route('pricelists.products.create', Auth::user()->pricelist->id) }}" class="btn btn-primary mb-3">
                Create a Product
            </a>
            <div class="card w-100">
                <div class="card-body">
                    <table id="example" class="table table-striped responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Price {{ Auth::user()->pricelist->currency }}</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($product->photo) }}" height="100px" width="100px"
                                            alt="">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a class="btn btn-outline-primary btn-sm me-2"
                                            href="{{ route('products.edit', $product->id) }}">
                                            Edit
                                        </a>
                                        <a class="btn btn-outline-danger btn-sm" href="" data-bs-toggle="modal"
                                            data-bs-target="#{{ $modalId }}" data-bs-title="Delete product"
                                            data-bs-content="Are you sure you want to delete this product?"
                                            data-bs-url="{{ route('products.destroy', $product->id) }}">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach --}}

                    </table>
                </div>
            </div>
            <x-ui.modal-delete :id="$modalId" />
        @endif
    </x-layouts.dashboard>
</x-layouts.app>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            info: false,
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('pricelists.products.index', Auth::user()->pricelist->id) }}",
            dataType: 'json',
            order:[[ 0, '' ]],
            columns: [
                {
                    data: 'photo',
                    name: 'photo',
                    orderable: false,
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'category_id',
                    name: 'category'
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                },


            ],
            "lengthChange": false,
            "pageLength": 10,
            "columnDefs": [{
                "width": "120px",
                "targets": 0
            }],
        });
    });
</script>
