<ukuran>{{ $ukuran }}</ukuran>




<div class="modal-dialog modal-{{ $ukuran }}">

    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="EditModalLabel">

                <titleeditModal>{{ $titleeditModal }}</titleeditModal>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <section>
                {{ $slot }}
            </section>

        </div>


    </div>
</div>
