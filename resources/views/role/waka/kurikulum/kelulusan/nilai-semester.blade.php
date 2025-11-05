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
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class="table-responsive">
                            <table id='example1' width='100%'
                                class='table table-bordered table-hover'>
                                <thead class="text-center">
                                    <tr class="table-primary">
                                        <th rowspan="2">Siswa</th>
                                        <th rowspan="2">Mata Pelajaran</th>
                                        @foreach ($tapelList as $tapel)
                                            <th colspan="3">Semester {{ $tapel - 2 }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="table-secondary">
                                        @foreach ($tapelList as $tapel)
                                            <th>P</th>
                                            <th>K</th>
                                            <th>RT</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($formattedData as $siswa)
                                        @foreach ($siswa['mapel'] as $mapel)
                                            <tr>
                                                <td>{{ $siswa['nama_siswa'] }}</td>
                                                <td>{{ $mapel['mapel'] }}</td>
                                                @foreach ($tapelList as $tapel)
                                                    <td class="text-center">
                                                        {{ $mapel['nilai'][$tapel]['pengetahuan'] ?? '-' }}</td>
                                                    <td class="text-center">
                                                        {{ $mapel['nilai'][$tapel]['keterampilan'] ?? '-' }}</td>
                                                    <td class="text-center">
                                                        {{ $mapel['nilai'][$tapel]['rata_rata'] ?? '-' }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>




                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

<script>
$(document).ready(function () {
  $('#example1').DataTable().destroy();
  $('#example1').DataTable({
    responsive: true,
    lengthChange: false,
    autoWidth: false,
    buttons: [
      'copy', 'csv', 'excel',
      {
        extend: 'pdfHtml5',
        text: 'PDF (Landscape)', // Label tombol
        orientation: 'landscape', // Set orientasi ke Landscape
        pageSize: 'A4' // Ukuran kertas (A3, A4, A5, dll.)
      },
      'print'
    ]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#example2').DataTable().destroy();
  $('#example2').DataTable({
    paging: true,
    lengthChange: false,
    searching: false,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true
  });
});
</script>