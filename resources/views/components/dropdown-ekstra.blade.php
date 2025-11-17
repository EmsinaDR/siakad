@php
use App\Models\Ekstra;

use App\Models\User;

$datadropdown = explode('/', $slot);
$datasitems = Ekstra::get();
@endphp
@if($datadropdown[3] === 'multiple')
<div class='form-group'>
    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
    <label>{{ $datadropdown[0]}}</label>
    <select id='multipleextra{{$datadropdown[1]}}' class='select2' name='{{$datadropdown[1]}}[]' multiple='multiple'
        data-placeholder='{{$datadropdown[2]}}' style='width: 100%; Required'>
        <option value=''>Pilih {{ $datadropdown[0]}} </option>
        @foreach($datasitems as $datasitem)
        <option value='{{ $datasitem->id}}'>{{ $datasitem->ekstra}}</option>
        @endforeach
    </select>
</div>
@else
<div class='form-group'>
    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
    <label>{{ $datadropdown[0]}}</label>
    <select id='{{$datadropdown[1]}}' class='form-control' name='{{$datadropdown[1]}}'
        data-placeholder='{{$datadropdown[2]}}' style='width: 100%; Required'>
        <option value=''> Pilih {{ $datadropdown[0]}}</option>
        @foreach($datasitems as $datasitem)
        <option value='{{ $datasitem->id}}'>{{ $datasitem->ekstra}}</option>
        @endforeach
    </select>
</div>
@endif
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#multipleextra{{$datadropdown[1]}}').select2()
    });
</script>