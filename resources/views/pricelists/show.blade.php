@php
    $pricelist = Auth::user()->pricelist;
@endphp

<x-layouts.app title="Price list">
    <x-layouts.dashboard class="">

        <div class="container">

            <div class="w-100 mb-3 rounded d-none d-md-block"
                style="height: 15rem; background-image: url({{ Storage::url($pricelist->cover) }}); background-size: cover; background-position: center center;  ">
                <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                    <img height="200px" width="200px" src="{{ Storage::url($pricelist->logo) }}"
                        class="rounded-circle shadow" alt="...">
                </div>
            </div>

            <div class="w-100 m-3 d-flex d-md-none justify-content-center align-items-center" style="height: 15rem;"">
                <img height="200px" width="200px" src="{{ Storage::url($pricelist->logo) }}"
                    class="rounded-circle shadow" alt="...">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="fw-bold fs-4">{{ $pricelist->name }}</div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('pricelists.edit', $pricelist->id) }}"
                        class="text-decoration-none d-flex align-items-center me-2">
                        Edit
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil-square ms-1" viewBox="0 0 16 16">
                            <path
                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z">
                            </path>
                        </svg>
                    </a>
                    <a href="" class="text-decoration-none text-danger d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                        Delete
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash3" viewBox="0 0 16 16">
                            <path
                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                        </svg>
                    </a>
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
        </div>


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="staticBackdropLabel">Delete price list</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this price list? All products and categories will be also delete
                        them.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <form method="POST" action="{{ route('pricelists.destroy', $pricelist->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-layouts.dashboard>
</x-layouts.app>
