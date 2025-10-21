{{-- {{$slot}} --}}

@php

$pairs = explode('/', $slot); // Memisahkan berdasarkan tanda /
$result = [];



foreach ($pairs as $pair) {
list($key, $value) = explode(':', $pair); // Memisahkan berdasarkan titik dua
$result[$key] = $value;
}
@endphp
@foreach($result as $key => $value)

<div class='form-group p-2'>
    <label for='{{ $value }}'>{{ $key }}</label>
<input type='text' class='form-control' id='{{ $value }}' name='{{ $value }}' placeholder='{{ $key }}' required>
</div>
@endforeach
