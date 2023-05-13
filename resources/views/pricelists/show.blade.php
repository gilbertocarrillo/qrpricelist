@php
    $pricelist = Auth::user()->pricelist;
    $modalId = 'deletePricelistModal';
@endphp

<x-layouts.app title="Price list">
    <x-layouts.dashboard class="">

        <div class="w-100 mb-3 rounded d-none d-md-block"
            style="height: 15rem; background-image: url({{ Storage::url($pricelist->cover) }}); background-size: cover; background-position: center center;  ">
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <img height="200px" width="200px" src="{{ Storage::url($pricelist->logo) }}" class="rounded-circle shadow"
                    alt="...">
            </div>
        </div>

        <div class="w-100 m-3 d-flex d-md-none justify-content-center align-items-center" style="height: 15rem;"">
            <img height="200px" width="200px" src="{{ Storage::url($pricelist->logo) }}" class="rounded-circle shadow"
                alt="...">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-1">
            <div class="fw-bold fs-4">{{ $pricelist->name }}</div>

            <div class="d-flex justify-content-end">
                <div>
                    <x-ui.actions-button :modalId="$modalId" title="Delete Price list"
                        content="Are you sure you want to delete this price list? All products and categories will be also delete
                            them."
                        :edit-url="route('pricelists.edit', $pricelist->id)" :delete-url="route('pricelists.destroy', $pricelist->id)" />
                </div>
            </div>
        </div>
        <p class="mb-3">
            {{ $pricelist->description }}
        </p>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="h5 lead">Contact info</div>
                        <div class="mb-1"><span class="fw-bold">Address: </span>{{ $pricelist->address }}</div>
                        <div class="mb-1"><span class="fw-bold">Phone: </span>{{ $pricelist->phone }}</div>
                        <div class="mb-3"><span class="fw-bold">Whatsapp: </span>{{ $pricelist->phone }}</div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-6">
                        <div class="h5 lead">Social networks</div>
                        <div class="mb-1"><a href="{{ $pricelist->facebook }}">Facebook</a></div>
                        <div class="mb-1"><a href="{{ $pricelist->instagram }}">Instagram</a></div>
                        <div class="mb-3"><a href="{{ $pricelist->twitter }}">Twitter</a></div>
                    </div>
                </div>
            </div>
        </div>

        <x-ui.modal-delete :id="$modalId" />

    </x-layouts.dashboard>
</x-layouts.app>
