@php
$data = explode('/', $slot);

@endphp
{{-- submit/Save/fa fa-save/btn btn-default bg-primary float-right --}}


{{-- submit / Nama Btn / ICON / Kelas / JSFUnction --}}
<button type="{{ $data[0] }}" class="btn {{ $data[3] }} mt-4"><i class="{{ $data[2] }}"></i> {{ $data[1] }}</button>
