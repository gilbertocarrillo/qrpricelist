@props(['id'])

<div class="modal fade" id="{{ $id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="staticBackdropLabel">...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    Modal = {{ $id }}
    Modal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget;

        // Extract info from data-bs-* attributes
        var title = button.getAttribute('data-bs-title');
        var content = button.getAttribute('data-bs-content');
        var url = button.getAttribute('data-bs-url');

        // Update the modal's content.
        var modalTitle = Modal.querySelector('.modal-title');
        var modalBody = Modal.querySelector('.modal-body');
        var form = Modal.querySelector('form');

        modalTitle.textContent = title;
        modalBody.innerHTML = content;
        form.action = url;
    })
</script>
