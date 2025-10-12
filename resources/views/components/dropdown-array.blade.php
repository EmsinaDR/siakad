@php
use App\Models\Ebkkreditpoint;
$dataslot = 'Jabatan/name/Ketua Kelas:Wakil Ketua:Bendahara:Sekretaris;Sie Agama:Sie. Kebersihan';
$datadropdown = explode('/', $dataslot);
// dd( $datadropdown[1]);


$options = explode(':', $datadropdown[2]);
// foreach ($options as $option) {
// list($key, $value) = explode(':', $option); // Memisahkan berdasarkan titik dua
// $result[$key] = $value;
// }



@endphp
<div class='form-group'>
    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
    <label>{{ $datadropdown[0]}}</label>

    <select id='{{$datadropdown[1]}}' class='select2' name='{{$datadropdown[1]}}[]' multiple='multiple' data-placeholder='{{$datadropdown[0]}}' style='width: 100%;'>

        <option value=''>--- Pilih {{ $datadropdown[0]}} ----</option>
        @foreach($options as $key => $value)
        <option value='{{ $key}}'>{{ $value}}</option>
        @endforeach
    </select>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#{{$datadropdown[1]}}').select2()

    });

</script>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>
