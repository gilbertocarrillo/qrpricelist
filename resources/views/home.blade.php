<x-layouts.app title="Home">
    <x-layouts.dashboard>
        @if (!Auth::user()->pricelist)
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="fs-4 text-secondary mb-2">
                    Price list not found
                </div>

                <a href="{{ route('pricelists.create') }}" class="btn btn-primary">
                    Create a Price list
                </a>
            </div>
        @else
            <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center flex-md-row align-items-md-stretch">
                        <img class="me-0 mb-3  mb-md-0 me-md-3" height="200px" width="200px"
                            src="{{ Storage::url(Auth::user()->pricelist->qrcode) }}" alt="">
                        <div class="w-100 d-flex flex-column justify-content-between">
                            <div class="d-flex flex-column align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <span class="fs-1 me-3">
                                        {{ Auth::user()->pricelist->name }}
                                    </span>

                                    <a class="me-3" href="{{ Auth::user()->pricelist->url }}" target="_blank"">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                            fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                            <path
                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                        </svg>
                                    </a>
                                </div>

                                <div class="mb-3">
                                    <span class="fw-light fs-5">Scans:</span>
                                    <span class="text-primary fw-bold">{{ Auth::user()->pricelist->scans }}</span>
                                </div>

                                <div class="d-flex align-items-center ">

                                    {{-- <span class="text-primary btn p-0 me-2" onclick="copyToClipboard()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                            <path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/>
                                            <path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/>
                                          </svg>
                                    </span> --}}

                                    <span id="url-pricelist" class="user-select-all"
                                        style="display: inline-block;width: 250px;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;"
                                        type="button"
                                        class="btn btn-secondary">{{ Auth::user()->pricelist->url }}</span>

                                    <span class="btn text-primary" onclick="copyToClipboard()" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Copy url">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                            fill="currentColor" class="bi bi-files" viewBox="0 0 16 16">
                                            <path
                                                d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>

                            <div class="d-grid w-100">
                                <a class="btn btn-primary" href="{{ Storage::url(Auth::user()->pricelist->qrcode) }}"
                                    target="_blank" download>Donwload</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-layouts.dashboard>

    @section('scripts')
        <script>
            var MyTooltip;

            $(document).ready(function() {
                MyTooltip = $('[data-bs-toggle="tooltip"]')
                MyTooltip.tooltip()
            });

            function copyToClipboard() {
                MyTooltip.attr("title", "Copied!").tooltip("_fixTitle").tooltip("show").attr("title", "Copy url").tooltip("_fixTitle");
                // Get the text field
                var copyText = document.getElementById("url-pricelist");
                // Copy the text inside the text field
                navigator.clipboard.writeText(copyText.innerHTML);
            }
        </script>
    @endsection
</x-layouts.app>
