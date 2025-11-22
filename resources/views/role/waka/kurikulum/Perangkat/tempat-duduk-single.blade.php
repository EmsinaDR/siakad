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


            <div class='row m-2'>
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i  class='fa fa-plus'></i> Tambah Data</button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class="col-xl-12">
                            <input type="checkbox" id="includeKop" checked> <label for="includeKop">Sertakan Kop Surat</label> <br>
                            <input type="checkbox" id="includeKopImage" checked> <label for="includeKopImage">Sertakan  Gambar dalam Kop</label> <br>
                            <button id="exportPDF" class="btn btn-danger mb-3">Export PDF</button>

                            <div id="pdf-content">
                                @foreach ($paired_data as $ruang => $pairs)
                                    <x-kop-surat id="kop-{{ Str::slug($ruang) }}"></x-kop-surat>
                                    <div class="room-page">
                                        <h3>Ruangan: {{ $ruang }}</h3>
                                        <table id="table-{{ Str::slug($ruang) }}" width="100%"
                                            class="table table-bordered">
                                            <thead>
                                                <tr class='text-center table-header'>
                                                    <th>No</th>
                                                    <th class='table-warning'>Nama Peserta</th>
                                                    <th class='table-warning'>No Test</th>
                                                    <th class='table-warning'>Kelas</th>
                                                    <th  class='table-success'>Nama Peserta</th>
                                                    <th  class='table-success'>No Test</th>
                                                    <th  class='table-success'>Kelas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pairs as $index => $pair)
                                                    <tr>
                                                        <td class='text-center'>{{ $index + 1 }}</td>
                                                        <td class='text-center'>
                                                            {{ $pair['first']->PesertaTestToDetailSiswa->nama_siswa }}
                                                        </td>
                                                        <td class='text-center'>{{ $pair['first']->nomor_test }} / {{ $pair['first'] ? $pair['first']->PesertaTestToKelas->kelas : '-' }} / {{date('Y')}}</td>
                                                        <td class='text-center'>
                                                            {{ $pair['first']->PesertaTestToKelas->kelas }}</td>
                                                        <td class='text-center'>
                                                            {{ $pair['second'] ? $pair['second']->PesertaTestToDetailSiswa->nama_siswa : '-' }}
                                                        </td>
                                                        <td class='text-center'>
                                                            {{ $pair['second'] ? $pair['second']->nomor_test : '-' }} / {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }} / {{date('Y')}}
                                                        </td>
                                                        <td class='text-center'>
                                                            {{ $pair['second'] ? $pair['second']->PesertaTestToKelas->kelas : '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="page-break"></div>
                                    </div>
                                @endforeach
                            </div>

                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

                            <script>
                                document.getElementById('exportPDF').addEventListener('click', async function() {
                                    const {
                                        jsPDF
                                    } = window.jspdf;
                                    const doc = new jsPDF('p', 'mm', 'a4');
                                    let rooms = document.querySelectorAll('.room-page');

                                    let includeKop = document.getElementById('includeKop').checked;
                                    let includeKopImage = document.getElementById('includeKopImage').checked;

                                    for (let i = 0; i < rooms.length; i++) {
                                        if (i !== 0) doc.addPage(); // Tambah halaman baru setelah halaman pertama

                                        let room = rooms[i];
                                        let roomTitle = room.querySelector("h3").innerText;
                                        let table = room.querySelector("table");

                                        if (includeKop) {
                                            let kopElement = document.querySelector(`#kop-${roomTitle.replace(/\s+/g, '-')}`);

                                            if (includeKopImage) {
                                                // Ambil kop surat sebagai gambar jika "Sertakan Gambar dalam Kop" dicentang
                                                let kopImage = await html2canvas(kopElement).then(canvas => canvas.toDataURL(
                                                    "image/png"));
                                                doc.addImage(kopImage, 'PNG', 15, 10, 180, 25); // Atur ukuran gambar
                                                doc.setFontSize(14);
                                                doc.text(roomTitle, 105, 40, null, null, 'center'); // Tambah teks setelah gambar
                                                doc.autoTable({
                                                    html: table,
                                                    startY: 50,
                                                    theme: 'grid'
                                                });
                                            } else {
                                                // Jika gambar dalam kop tidak disertakan, hanya teks kop surat yang ditambahkan
                                                doc.setFontSize(14);
                                                doc.text("KOP SURAT", 105, 15, null, null, 'center'); // Judul kop surat
                                                doc.text(roomTitle, 105, 25, null, null, 'center'); // Nama ruangan
                                                doc.autoTable({
                                                    html: table,
                                                    startY: 30,
                                                    theme: 'grid'
                                                });
                                            }
                                        } else {
                                            // Jika kop surat tidak disertakan, hanya tabel yang ditampilkan
                                            doc.setFontSize(14);
                                            doc.text(roomTitle, 105, 15, null, null, 'center'); // Judul ruangan
                                            doc.autoTable({
                                                html: table,
                                                startY: 25,
                                                theme: 'grid'
                                            });
                                        }
                                    }

                                    doc.save("PasanganDuduk.pdf");
                                });
                            </script>
                        </div>

                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
