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
                    <table id="products-table" class="table table-striped table table-striped responsive align-middle"
                        style="width: 100%">
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
                    </table>
                </div>
            </div>
            <x-ui.modal-delete :id="$modalId" />
        @endif
    </x-layouts.dashboard>
</x-layouts.app>
<script>
    $(document).ready(function() {
        $('#products-table').DataTable({
            responsive: true,
            info: false,
            processing: true,
            serverSide: true,

            ajax: "{{ route('pricelists.products.index', Auth::user()->pricelist->id) }}",
            dataType: 'json',
            order: [
                [0, '']
            ],
            columns: [{
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
                    "targets": [0,1,3,4]
                },
                {
                    "width": "100px",
                    "targets": [5]
                },
            ],
        });
    });
</script>
