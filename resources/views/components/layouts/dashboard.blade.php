<div class="container-fluid overflow-hidden">
    <div class="row vh-100">
        <div class="d-none d-md-flex col-md-3 col-xl-2 flex-column flex-shrink-0 p-3 text-white bg-dark">
            <x-layouts.side-bar />
        </div>
        <x-layouts.nav-bar />
        <div {{ $attributes->merge(['class' => 'col h-100 px-4 p-md-4 overflow-auto position-relative']) }}
            style="padding-top: 4.5rem">
            @if (session('status'))
                <div class="alert alert-primary position-absolute alert-dismissible fade show top-1 start-50 translate-middle-x"
                    role="alert" style="z-index: 1060;">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
