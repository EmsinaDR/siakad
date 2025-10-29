@php
use App\Models\Admin\Etapel;

$activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
$semesteraktif = Etapel::where('aktiv', 'Y')->first();
$myTapel = $semesteraktif->tapel;
$myTapelId = $semesteraktif->id;
$semester = $semesteraktif->semester;
$semesterId = $semesteraktif->id;



@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <x-plugins-tabel-header></x-plugins-tabel-header>
        <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
        <div class='card'>
            <div class='ml-2'>
                <div class="card mt-2">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card-header bg-primary">
                                <h5 class="cardtitle">Pengaturan Tahun Pelajaran</h5>
                            </div>
                            <div class="card-body">
                                <form id='updateTapel' method='POST'>
                                    @csrf
                                    @method('PATCH')
                                    <div class='form-group'>
                                        <label for='tapel'>Tahun Pelajaran</label>
                                        <select id='myTapel' name=' tapel' class='form-control' required>
                                            <option id="remover" value='{{ $semesteraktif->id }}'>{{$semesteraktif->tapel}} - {{$semesteraktif->tapel + 1}} ( Semester {{ $semesteraktif->semester }} )</option>
                                            @foreach($dataTapels as $etapel)
                                            <option value='{{ $etapel->id }}'>{{ $etapel->tapel }} - {{ $etapel->tapel + 1 }} ( Semester {{ $etapel->semester }} )</option>
                                            @endforeach
                                            <option value='{{ $dataTapels->max()->id + 1}}'>{{ $etapelsNext->tapel + 1}} - {{ $etapelsNext->tapel + 2 }} ( Tahun Pelajaran Berikutnya)</option>
                                        </select>
                                    </div>
                                    <div id='semester' class='form-group'>
                                        <label for='tapel'>Semester</label>
                                        <select id='mySemester' name='semester' class='select2 form-control' disabled>
                                            <option value='{{ $semesterId }}'>{{$semester}}</option>
                                            <option id='#option' value='I'>I</option>
                                            <option id='#option' value='II'>II</option>
                                        </select>
                                    </div>
                                    <div id="btnupdate">
                                        <x-btn>submit/Kirim/fa fa-save/btn btn-primary btn-xl bg-primary float-right mt-4 / </x-btn>
                                    </div>
                                </form>

                            </div>
                            <script>
                                $('#btnupdate').hide();

                                $(document).ready(function() {
                                    //Tapel

                                    $('#myTapel').change(function() {
                                        $('#remover').remove();
                                    })
                                    // var myTapel = @json($myTapel);
                                    // $('#myTapel').find('option[value="' + myTapel + '"]').remove();
                                    // alert('Selected Text: ' + myTapel);
                                    // //Semester
                                    var nilaisemseter = @json($semester);
                                    $('#mySemester').find('option[value="' + nilaisemseter + '"]').remove();
                                    // alert('Selected Text: ' + nilaisemseter);
                                    $('#myTapel').change(function() {
                                        let selectedValue = $(this).val();
                                        // alert('Selected Value: ' + selectedValue);
                                        $('#btnupdate').show();
                                        $('#updateTapel').attr('action', 'etapel/' + selectedValue);
                                    });
                                })

                            </script>
                        </div>
                        <div class="col-xl-6">

                            <div class="alert alert-success" style='opacity:0.85' role="alert">
                                <h4 class="alert-heading"><b>Pengaturan Tahun Pelajaran</b></h4>

                                <p>Pengaturan ini digunakan untuk setting data aktiv pada setiap bagian secara berkala sesuai dengan kebutuhan data sekolah</p>
                                <ul>
                                    <li>
                                        Tahun Pelajaran
                                    </li>
                                    <li>
                                        Semester
                                    </li>
                                </ul>
                                <p>
                                    Jika perubahan tahun pelajaran data akan kosong kembali sesuai kebutuhan bukan berarrti hilang tetapi hanya ditampilkan berdasarkan tahun pelajaran aktiv sesuai kebutuhan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layout>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>
