@php
use App\Models\Admin\Ekelas;
use App\Models\User;

$datadropdown = explode('/', $slot);
$users = User::where('posisi', 'Guru')->get();
// dd($users);
// Nama Guru/nama_guru/Placeholder

@endphp
<div class='form-group p-2'>

    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
    <label>{{ $datadropdown[0]}}</label>

    <select id='{{$datadropdown[1]}}' class='select2' name='{{$datadropdown[1]}}[]' multiple='multiple' data-placeholder='{{$datadropdown[2]}}' style='width: 100%;'>
        <option value=''>--- Pilih {{ $datadropdown[0]}} ----</option>
        @foreach($users as $user)
        <option value='{{ $user->UsersDetailgurus->id}}'>{{ $user->UsersDetailgurus->nama_guru}}</option>


        @endforeach
    </select>
</div>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('#{{$datadropdown[1]}}').select2()
    });
</script>