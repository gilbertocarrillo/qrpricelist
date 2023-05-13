@props(['modalId', 'title', 'content', 'editUrl', 'deleteUrl'])

<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
        aria-expanded="false">
        Actions
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a class="dropdown-item" href="{{ $editUrl }}"">
                Edit
            </a>
        </li>
        <li>
            <a class="dropdown-item text-danger" href="" data-bs-toggle="modal"
                data-bs-target="#{{ $modalId }}" data-bs-title="{{ $title }}"
                data-bs-content="{{ $content }}" data-bs-url="{{ $deleteUrl }}">
                Delete
            </a>
        </li>
    </ul>
</div>
