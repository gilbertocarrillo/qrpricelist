<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
        <div class="navbar-brand"></div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="#">Price List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}"
                        href="#">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cateogory.index') ? 'active' : '' }}"
                        href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('pricelist.show') ? 'active' : '' }}""
                        href="#">Preview</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"" href="#">Profile</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            Logout
                        </a>
                    </form>

                </li>
            </ul>
        </div>
    </div>
</nav>
