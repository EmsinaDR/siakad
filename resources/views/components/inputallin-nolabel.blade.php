{{-- {{$slot}} --}}
{{--
$lot[0] => typeinput (textarea/file/date/email/tel/url/password/number)
$slot[1] => Label
$lot[2] => Placeholder
$lot[3] => name
$lot[4] => id
$lot[5] => Required / readonly / disabled + id tambahan lain
:Nama Guru:Nama Guru:nama_guru:nama_guru:min='0' max='5' Required
type/Label/Placeholder/name/id/Required + dll
min='0' max='5'


textarea : textarea:Keterangan:Isikan Keterangan Detail Tugas yang dapat dijelaskan:keterangan:keterangan:rows=4 Required

--}}
<style>
    textarea {
        resize: none;
    }

</style>

@php
use App\Models\Admin\Ekelas;
use App\Models\Ekstra;
use App\Models\User;
use App\Models\Elaboratorium;
use App\Models\Elist;

$pairs = explode('/', $slot); // Memisahkan berdasarkan tanda /
$result = [];

for($i=0;$i< count($pairs);$i++): $pairs[$i]=explode(':', $pairs[$i]); endfor; @endphp @for($i=0; $i < count($pairs); $i++) {{-- <div class='form-group p-2'> --}}


    @if($pairs[$i][0] === 'textarea')
    <textarea type='text' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' {{ $pairs[$i][6]  }}>{{ $pairs[$i][5]}}</textarea>
    @elseif($pairs[$i][0] === 'file')

    <input type='file' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'email')
    <input type='email' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'tel')
    <input type='tel' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'url')

    <input type='url' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'number')

    <input type='number' max="100" class='form-control text-center' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}} >

    @elseif($pairs[$i][0] === 'password')
    <input type='password' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'hidden')
    <input type='hidden' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>

    @elseif($pairs[$i][0] === 'readonly')
    <input type='disabled' class='form-control bg-white' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>



    @elseif($pairs[$i][0] === 'dropdown-single')
    <select id='{{$pairs[$i][4]}}' class='form-control' name='{{$pairs[$i][3]}}' data-placeholder='{{$pairs[$i][2]}}' style='width: 100%;' {{$pairs[$i][6]}}>
        <option value=''>--- Pilih {{ $pairs[$i][2]}} ----</option>
        @if($pairs[$i][5] === 'kelas')
            @php
                $datadropdwons = Ekelas::get();
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->id}}'>{{ $datadropdwon->kelas}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'guru')
            @php
                $datadropdwons = User::where('posisi', 'Guru')->get();
                // dd($datadropdwons);
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->UsersDetailgurus->id}}'>{{ $datadropdwon->UsersDetailgurus->nama_guru}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'siswa')
            @php
                $datadropdwons = User::where('posisi', 'Siswa')->get();
                // dd($datadropdwons);
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->UsersDetailsiswa->id}}'>{{ $datadropdwon->UsersDetailsiswa->nama_guru}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'karyawan')
            @php
                $datadropdwons = User::where('posisi', 'Karyawan')->get();
                // dd($datadropdwons);
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->UsersDetailsiswa->id}}'>{{ $datadropdwon->UsersDetailsiswa->nama_guru}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'ekstra')
            @php
                $datadropdwons = Ekstra::get();
                // dd($datadropdwons);
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->id}}'>{{ $datadropdwon->ekstra}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'laboratorium')
            @php
                $datadropdwons = Elaboratorium::get();
                // dd($datadropdwons);
            @endphp
                @foreach($datadropdwons as $datadropdwon)
                <option value='{{ $datadropdwon->id}}'>{{ $datadropdwon->name}}</option>
                @endforeach
        @elseif($pairs[$i][5] === 'jenis_kelamin')
            @php
                $jenis_kelamins = Elist::where('kategori', 'Jenis Kelamin')->get();
                // dd($datadropdwons);
            @endphp
                @foreach($jenis_kelamins as $jenis_kelamin)
                <option value='{{ $jenis_kelamin->id}}'>{{ $jenis_kelamin->list}}</option>
                @endforeach
        @else
        @endif
    </select>

    @elseif($pairs[$i][0] === 'date')
    <input type='date' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>
    @elseif($pairs[$i][0] === 'text-center')
    <input type='text' class='form-control text-center' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>
    @else
    <input type='text' class='form-control' id='{{ $pairs[$i][4] }}' name='{{ $pairs[$i][3] }}' placeholder='{{ $pairs[$i][2] }}' value='{{ $pairs[$i][5]}}' {{ $pairs[$i][6]}}>
    @endif
    {{-- </div> --}}
    @endfor
