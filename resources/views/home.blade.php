<x-layouts.app title="Home">
    <x-layouts.nav />
    <div class="vh-100" style="padding-top: 56px;">
            {{Auth::user()}}
    </div>
</x-layouts.app>
