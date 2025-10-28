@php
use App\Models\Admin\Ekelas;
use App\Models\User;
use App\Models\User\Guru\Detailguru;


$datadropdown = explode('/', $slot);
// $users = User::where('posisi', 'Guru')->get();
$gurus = App\Models\User\Guru\Detailguru::get();



// dd($gurus);
// dd($users);
// Nama Guru/nama_guru/Placeholder
//Label/Placeholder/name/id_name/value/tambahan
//Nama Wali Kelas/Placeholder/nama_guru/enama_guru//
//Nama Guru/Nama Guru/nama_guru/enama_guru//


// dd($users);
// dd($gurus);


// dd($datadropdown[4]);

@endphp
<div class='form-group'>

    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
    <label for='{{$datadropdown[3]}}'>{{ $datadropdown[0]}}</label>


    <select id='{{$datadropdown[3]}}' class='form-control' name='{{$datadropdown[2]}}' style='width: 100%;' {{$datadropdown[5]}}>
        {{-- <option id='remover' value=''>--- Pilih {{ $datadropdown[4]}} ----</option> --}}
        <option value=''>--- Pilih Nama Guru ---</option>
        @foreach($gurus as $user)
        {{-- <option value='{{ $user->id}}'>{{ $user->UsersDetailgurus->nama_guru}}</option> --}}
        <option value='{{ $user->id}}'>{{ $user->nama_guru}}</option>
        @endforeach
    </select>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#{{$datadropdown[3]}}').select2()
    });
    $('#{{$datadropdown[3]}}').text(@json($datadropdown[4])); // Option 2 will be selected
</script>
