@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            {{-- Papan Informasi --}}


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                    {{--  --}}
                   </div>
                   <div class='col-xl-10'>
                    <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;">
  <thead style="background-color: #f2f2f2;">
    <tr class='text-center align-middle'>
      <th>Jenis Analisis</th>
      <th>Unit Analisis</th>
      <th>Rumus</th>
      <th>Tujuan</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Daya Serap Individu</td>
      <td>Per siswa</td>
      <td>(Benar ÷ Total soal) × 100%</td>
      <td>Menilai siswa satu per satu</td>
    </tr>
    <tr>
      <td>Daya Serap Materi</td>
      <td>Per soal/materi</td>
      <td>(Siswa benar ÷ Total siswa) × 100%</td>
      <td>Menilai pemahaman terhadap materi</td>
    </tr>
    <tr>
      <td>Daya Serap KKM</td>
      <td>Per materi</td>
      <td>(Siswa tuntas ÷ Total siswa) × 100%</td>
      <td>Menilai ketuntasan terhadap materi</td>
    </tr>
  </tbody>
</table>

                   </div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">

                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class='card-header bg-primary d-flex justify-content-center mt-5'>
                            <h3 class='card-title text-center'>Data Tingkat Kesukaran</h3>
                        </div>
                        <table id='example1x' width='100%' class='table table-bordered table-hover mt-3'>
                            <thead>
                                <tr class='text-center align-middle'>
                                    <th class='text-center align-middle' rowspan='2'>Siswa</th>
                                    <th colspan='{{ $soals->count() }}'>Nomor Soal</th>
                                </tr>
                                @foreach ($soals as $soal)
                                    <th class='text-center align-middle'>{{ $soal->id }}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($jawaban_siswa as $siswa_id => $jawaban)
                                    <tr>
                                        <td>{{ $jawaban['nama_siswa'] }}</td> <!-- Ganti dengan nama siswa -->
                                        @foreach ($soals as $soal)
                                            <td class='text-center align-middle'>
                                                @if (isset($jawaban[$soal->id]))
                                                    {{ $jawaban[$soal->id] }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class='table-success'>
                                <tr>
                                    <td class='text-center align-middle'>Total Benar</td>
                                    @foreach ($soals as $soal)
                                        <td class='text-center align-middle'>{{ $correctAnswersCount[$soal->id] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class='text-center align-middle'>Total Salah</td>
                                    @foreach ($soals as $soal)
                                        <td class='text-center align-middle'>{{ $wrongAnswersCount[$soal->id] }}</td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class='text-center align-middle'>Rasio Benar / Siswa</td>
                                    @foreach ($soals as $soal)
                                        <td class='text-center align-middle'>
                                            @php
                                                $rasioBenar = $correctAnswersCount[$soal->id] / $jml_siswa;
                                                $rasioRounded = round($rasioBenar, 2); // Pembulatan angka ke 2 angka desimal
                                            @endphp

                                            {{ $rasioRounded }} <!-- Menampilkan nilai yang sudah dibulatkan -->
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class='text-center align-middle'>Tingkat Kesukaran</td>
                                    @foreach ($soals as $soal)
                                        <td class="text-center">
                                            @php
                                                $rasioRounded = $correctAnswersCount[$soal->id] / $jml_siswa;
                                            @endphp
                                            @if ($rasioRounded < 0.3)
                                                <!-- Ikon untuk 'Sukar' (SK) -->
                                                <span
                                                    class="p-2 rounded-pill bg-danger text-white d-inline-flex align-items-center justify-content-center"
                                                    style="width: 20px; height: 20px; font-size: 9px;">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </span>
                                            @elseif ($rasioRounded < 0.7)
                                                <!-- Ikon untuk 'Sedang' (SD) -->
                                                <span
                                                    class="p-2 rounded-pill bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                                    style="width: 20px; height: 20px; font-size: 9px;">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </span>
                                            @else
                                                <!-- Ikon untuk 'Mudah' (MD) -->
                                                <span
                                                    class="p-2 rounded-pill bg-success text-white d-inline-flex align-items-center justify-content-center"
                                                    style="width: 20px; height: 20px; font-size: 9px;">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    <td class='text-center align-middle'>Daya Serap Soal</td>
                                    @foreach ($soals as $soal)
                                        <td class='text-center align-middle' style='font-size:12px'>
                                            {{ $rasioRounded * 100 }} %
                                            <!-- Menampilkan nilai yang sudah dibulatkan -->
                                        </td>
                                    @endforeach
                                </tr>


                            </tfoot>
                        </table>

                        <table id='example1x' width='100%'
                            class='table table-responsive table-bordered table-hover mt-5'>
                            <tbody>
                                <tr>
                                    <td style="min-width: 50px; text-align: justify;">Kurang dari 0,30&nbsp;</td>
                                    <td>&nbsp;=&nbsp;</td>
                                    <td>&nbsp;Terlalu sukar</td>
                                    <td>&nbsp;<span
                                            class="p-2 rounded-pill bg-danger text-white d-inline-flex align-items-center justify-content-center"
                                            style="width: 20px; height: 20px; font-size: 9px;">
                                            <i class="fas fa-exclamation-circle"></i>
                                        </span></td>
                                </tr>
                                <tr>
                                    <td>0,30 - 0,70</td>
                                    <td>&nbsp;=</td>
                                    <td>&nbsp;Cukup (Sedang)</td>
                                    <td>&nbsp;<span
                                            class="p-2 rounded-pill bg-primary text-white d-inline-flex align-items-center justify-content-center"
                                            style="width: 20px; height: 20px; font-size: 9px;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span></td>
                                </tr>
                                <tr>
                                    <td style="min-width: 50px; text-align: justify;">Lebih dari 0,70</td>
                                    <td>&nbsp;=</td>
                                    <td>&nbsp;Terlalu mudah</td>
                                    <td>&nbsp; <span
                                            class="p-2 rounded-pill bg-success text-white d-inline-flex align-items-center justify-content-center"
                                            style="width: 20px; height: 20px; font-size: 9px;">
                                            <i class="fas fa-check-circle"></i>
                                        </span></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
