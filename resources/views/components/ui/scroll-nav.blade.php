@props(['categories'])

<nav id="scrollNavBar" class="d-flex mb-4 justify-content-between align-items-center px-2 bg-primary sticky-top rounded"
    style="height: 3.5rem;">
    <button type="button" id="left" class="btn btn-primary me-3" onclick="rightScroll()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-left"
            viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
        </svg>
    </button>
    <div class="d-flex flex-nowrap scroll-nav-bar">
        @foreach ($categories as $category)
            <a class="btn btn-outline-light text-nowrap me-2" href="#p{{ $category->id}}">{{ $category->name }}</a>
        @endforeach
    </div>
    <button type="button" id="right" class="btn btn-primary ms-3" onclick="leftScroll()">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
        </svg>
    </button>

</nav>

<script>
    function leftScroll() {
        const left = document.querySelector('.scroll-nav-bar');
        left.scrollBy(200, 0);
    }

    function rightScroll() {
        const right = document.querySelector('.scroll-nav-bar');
        right.scrollBy(-200, 0);
    }
</script>
