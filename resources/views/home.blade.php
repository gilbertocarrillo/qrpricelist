<x-layouts.app title="Home">
    <x-layouts.dashboard>
        @if (!Auth::user()->pricelist)
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="fs-4 text-secondary mb-2">
                    Price list not found
                </div>

                <a href="{{ route('home') }}" class="btn btn-primary">
                    Create a Price list
                </a>
            </div>
        @else
            <div class="display-4">
                Home
            </div>
        @endif
    </x-layouts.dashboard>
</x-layouts.app>
