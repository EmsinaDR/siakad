@php
$data = explode('/', $slot);

@endphp

<button type="{{ $data[0] }}" class="btn btn-primary"><i class="fa fa-save"></i> {{ $data[1] }}</button>
