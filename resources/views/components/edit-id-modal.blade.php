{{-- @php
$idmodaledit = explode("/", $slot);
// dd($idmodal);
@endphp
<div class="modal fade" id="{{$idmodaledit[0]}}" tabindex="-1" aria-labelledby="EditModal" aria-hidden="true">

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header bg-primary">
            <h5 class="modal-title" id="EditModal">{{ $idmodaledit[1] }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div> --}}


        {{-- {{ $slot }} --}}
        <!-- Modal -->
        <div class="modal fade" id="EditKaldik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">


            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Edit
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
