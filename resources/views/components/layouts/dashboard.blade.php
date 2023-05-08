<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="d-none d-md-flex col-md-3 col-xl-2 flex-column flex-shrink-0 p-3 text-white bg-dark">
            <x-layouts.side-bar />
        </div>
            <x-layouts.nav-bar/>
        <div class="col h-100">
            {{ $slot }}
        </div>
    </div>
</div>
