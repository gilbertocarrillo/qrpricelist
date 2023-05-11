<div class="container-fluid overflow-hidden">
    <div class="row vh-100">
        <div class="d-none d-md-flex col-md-3 col-xl-2 flex-column flex-shrink-0 p-3 text-white bg-dark">
            <x-layouts.side-bar />
        </div>
            <x-layouts.nav-bar/>
        <div {{ $attributes->merge(['class' => "col h-100 px-4 p-md-4 overflow-auto"])}} style="padding-top: 4.5rem">
            {{ $slot }}
        </div>
    </div>
</div>
