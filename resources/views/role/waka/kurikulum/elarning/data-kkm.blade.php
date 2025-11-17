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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i
                            class='fa fa-plus'></i> Tambah Data</button>
                </div>
                <div class='col-xl-10'></div>
            </div>


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data KKM Mapel</h3>
                    </div>
                    <div class='card-body'>
                        <h2 class="mb-3">Data KKM Per Mapel</h2>
                        @php
                            $kkmPerTingkat = [];

                            foreach ([7, 8, 9] as $tingkat) {
                                $kkmPerTingkat[$tingkat] = $datas->where('tingkat_id', $tingkat)->pluck('kkm');
                            }

                            $rataRataKKM = [];

                            foreach ($kkmPerTingkat as $tingkat => $kkms) {
                                $rataRataKKM[$tingkat] = $kkms->count() > 0 ? $kkms->avg() : 0;
                            }
                        @endphp
                        <button id='BTNpdf' type='button' onclick='ExportPdf()' class='btn btn-default bg-success btn-md'> <i class='fa fa-file-pdf mr-2'></i>Export to PDF </button>


                        <div id='divToExport' class='mt-1'>
                        <table id="kkmTable" class="table table-bordered table-striped table-hover">
                            <thead class="table-primary text-center align-middle">
                                <tr>
                                    <th width='1%' rowspan="2" class="align-middle">No</th>
                                    <th rowspan="2" class="align-middle">Mapel</th>
                                    <th rowspan="2" class="align-middle">JTM</th>
                                    <th colspan="3">Kelas</th>
                                </tr>
                                <tr>
                                    <th>Kelas 7</th>
                                    <th>Kelas 8</th>
                                    <th>Kelas 9</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas->groupBy('mapel_id') as $mapelId => $mapelData)
                                    <tr class="text-center align-middle">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left fw-semibold">
                                            {{ $mapelData->first()->mapel->mapel ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td class="text-start fw-semibold">
                                            @php
                                                $JTM = \App\Models\Admin\Emapel::where(
                                                    'mapel',
                                                    $mapelData->first()->mapel->mapel,
                                                )->first();
                                            @endphp
                                            {{ $JTM->jtm }}
                                        </td>
                                        @foreach ([7, 8, 9] as $tingkat)
                                            @php
                                                $kkmData = $mapelData->where('tingkat_id', $tingkat)->first();
                                            @endphp
                                            <td class="editable" data-id="{{ $kkmData->id ?? '' }}" data-field="kkm"
                                                data-tingkat_id="{{ $tingkat }}"
                                                data-mapel_id="{{ $mapelId }}">
                                                {{ $kkmData->kkm ?? '-' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr class="table-warning fw-bold text-center">
                                    <td colspan='3' class="text-start">Rata-rata KKM</td>
                                    <td>{{ number_format($rataRataKKM[7] ?? 0, 2) }}</td>
                                    <td>{{ number_format($rataRataKKM[8] ?? 0, 2) }}</td>
                                    <td>{{ number_format($rataRataKKM[9] ?? 0, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        </div>

                        <script>
                            function ExportPdf() {
    // Ambil elemen yang ingin diekspor ke PDF
    const element = document.getElementById('divToExport');

    // Konfigurasi opsi untuk konversi HTML ke PDF
    const options = {
        margin: [10, 10, 10, 10], // Margin lebih kecil agar tidak ada halaman kosong
        filename: 'Data KKM.pdf', // Nama file PDF

        // Konfigurasi gambar dalam PDF
        image: {
            type: 'jpeg', // Format gambar dalam PDF
            quality: 1 // Kualitas gambar maksimal
        },

        // Pengaturan untuk html2canvas (digunakan untuk menangkap elemen HTML)
        html2canvas: {
            scale: 1.5, // Menjaga keseimbangan antara ukuran dan kualitas
            scrollY: 0 // Mencegah efek scroll saat menangkap elemen
        },

        // Konfigurasi untuk jsPDF (library yang menangani pembuatan PDF)
        jsPDF: {
            unit: 'mm', // Menggunakan satuan milimeter
            format: 'a4', // Menggunakan ukuran kertas A4 agar lebih umum
            orientation: 'portrait' // Mode orientasi PDF (portrait atau landscape)
        }
    };

    // Proses konversi elemen HTML menjadi PDF dan mengunduhnya
    html2pdf().from(element).set(options).save();
}

                        </script>


                        <!-- jQuery & AJAX -->
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function() {
                                $("#kkmTable").on("dblclick", ".editable", function() {
                                    var currentElement = $(this);
                                    var currentText = currentElement.text().trim();
                                    var id = currentElement.data("id");
                                    var field = currentElement.data("field");

                                    if (!id || id === "") {
                                        // alert("Data tidak bisa diedit, ID tidak ditemukan.");
                                        return;
                                    }
                                    var inputField = $("<input>", {
                                        type: "number",
                                        class: "form-control",
                                        value: currentText,
                                        min: 0,
                                        max: 100
                                    });
                                    currentElement.html(inputField);
                                    inputField.focus();

                                    inputField.blur(function() {
                                        saveData(currentElement, inputField.val(), id, field);
                                    });

                                    inputField.keypress(function(e) {
                                        if (e.which === 13) {
                                            saveData(currentElement, inputField.val(), id, field);
                                        }
                                    });
                                });

                                function saveData(element, newValue, id, field, tingkat_id, mapel_id) {
                                    console.log("Mengirim data...", {
                                        id,
                                        field,
                                        newValue,
                                        tingkat_id,
                                        mapel_id
                                    }); // Debugging

                                    $.ajax({
                                        url: "{{ route('waka.kurikulum.update-kkm') }}", // Gunakan route yang sama untuk update & create
                                        type: "POST",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            id: id, // Jika kosong, akan dibuat data baru di controller
                                            field: field,
                                            value: newValue,
                                            tingkat_id: tingkat_id,
                                            mapel_id: mapel_id
                                        },
                                        success: function(response) {
                                            console.log("Berhasil:", response); // Debugging sukses
                                            element.attr("data-id", response.data.id); // Update ID yang baru dibuat
                                            element.text(newValue); // Perbarui tampilan
                                        },
                                        error: function(xhr, status, error) {
                                            console.error("Error:", xhr.responseText); // Debugging error
                                            // alert("Gagal menyimpan data! Cek Console (F12 - Network - XHR)");
                                        }
                                    });
                                }
                                $("#kkmTable").on("dblclick", ".editable", function() {
                                    var currentElement = $(this);
                                    var currentText = currentElement.text().trim();
                                    var id = currentElement.data("id");
                                    var field = currentElement.data("field");
                                    var tingkat_id = currentElement.data("tingkat_id");
                                    var mapel_id = currentElement.data("mapel_id");

                                    console.log("Klik ganda pada elemen:", {
                                        id,
                                        field,
                                        tingkat_id,
                                        mapel_id
                                    }); // Debugging

                                    if (!tingkat_id || !mapel_id) {
                                        console.error("ERROR: tingkat_id atau mapel_id tidak ditemukan!", {
                                            tingkat_id,
                                            mapel_id
                                        });
                                        // alert("Gagal mengedit! Data tidak lengkap.");
                                        return;
                                    }

                                    var inputField = $("<input>", {
                                        type: "number",
                                        class: "form-control",
                                        value: currentText,
                                        min: 0,
                                        max: 100
                                    });

                                    currentElement.html(inputField);
                                    inputField.focus();

                                    inputField.blur(function() {
                                        saveData(currentElement, inputField.val(), id, field, tingkat_id, mapel_id);
                                    });

                                    inputField.keypress(function(e) {
                                        if (e.which === 13) {
                                            saveData(currentElement, inputField.val(), id, field, tingkat_id, mapel_id);
                                        }
                                    });
                                });



                            });
                        </script>






                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
