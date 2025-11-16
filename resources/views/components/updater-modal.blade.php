<div class="modal-dialog  modal-lg">
    <div class="modal-content">

        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="updateModalLabel">
                {{-- <titleupdateModal>{{ $titleupdateModal }}</titleupdateModal> --}}update
            </h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <section>{{ $slot }}</section>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>


    </div>
</div>
