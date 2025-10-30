<div class="modal-dialog  modal-lg">
    {{-- <div class="modal fade" id="modalEditor" z-index='1' aria-hidden="true"> --}}
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="ViewModalLabel">
                <titleviewModal>{{ $titleviewModal }}</titleviewModal>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <section>{{ $slot }}</section>
        </div>
    </div>
    {{-- </div> --}}
