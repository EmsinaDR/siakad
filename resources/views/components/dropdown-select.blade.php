<x-plugins-multiple-select-header></x-plugins-multiple-select-header>
{{-- {{dd($slot)}} --}}

@php

$datadropdown = explode('/', $slot);
// dd($datadropdown);
// dd($datadropdown[1]);
$name_label = explode(':', $datadropdown[0]);

// dd($name_label[1]);
$keys = explode(',', $datadropdown[1]);

$values = explode(',', $datadropdown[2]);
$options = collect($keys)->combine($values);
$type = $datadropdown[3];

// dd($name_label[1]);
@endphp


@if($type === 'multiple')
{{ $name_label[1] }}
<div class='form-group p-2'>
    {{-- <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda --> --}}
    <label for='{{ $name_label[1] }}'>{{ $name_label[0] }} Multiple</label>

    <select id='{{ $name_label[1] }}' class='select2' name='{{ $name_label[1] }}[]' multiple='multiple' data-placeholder='{{ $datadropdown[4] }}' style='width: 100%;'>
        <option value=''>--- Pilih {{ $name_label[0]}} ----</option>
        @foreach($options as $key => $value)
        <option value='{{ $key }}'>{{ $value }}</option>
        @endforeach
    </select>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#{{ $name_label[1] }}').select2()


    });

</script>
@else
{{-- Harusnya multiple --}}
<div class='form-group p-2'>

    <label for='{{ $name_label[1] }}'>{{ $name_label[0] }}</label>

    <select name='{{ $name_label[1] }}' class='form-control' required>
        <option value=''>--- Pilih {{ $name_label[0] }} ---</option>
        @foreach($options as $key => $value)
        <option value='{{ $key }}'>{{ $value }}</option>
        @endforeach
    </select>
</div>

@endif
