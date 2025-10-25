<style>
    .text-danger {
        color: #dc3545 !important;
        /* Warna merah dari Bootstrap */
    }
</style>
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
                <h3 class='card-title'>{{ $title }} dan Pengawasan</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='CekKode()'> <i class='fa fa-eye'></i> Lihat Kode Guru</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='BuatJadwal()'> <i class='fa fa-plus'></i> Tambah Test</button>
                    <button type='button' class='btn btn-block btn-default bg-danger btn-md' onclick='HapusMapel()'> <i class='fa fa-trash'></i> Hapus Mapel</button>
                    <button type='button' id="resetJadwal" class='btn btn-block btn-default bg-danger btn-md' > <i class='fa fa-recycle'></i> Reset Jadwal</button>
                   <form id="resetForm" action="{{ route('waka.jadwal.Resset') }}" method="GET" style="display: none;">
                        @csrf
                    </form>

                    <script>
                        document.getElementById('resetJadwal').addEventListener('click', function () {
                            Swal.fire({
                                title: 'Apakah Anda yakin?',
                                text: "Semua jadwal akan dihapus dan tidak bisa dikembalikan! Pengaturan yang disimpan akan hilang",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Reset!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('resetForm').submit();
                                }
                            });
                        });
                    </script>


                </div>
                <div class='col-xl-10'></div>
            </div>
            {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Cek Jumlah Pengawasan</h3>
                    </div>
                    <div class='card-body'>
                        <h2 class="text-center mb-4">Jumlah Pengawasan Berdasarkan Guru</h2>
                        <table id='example4' class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class='text-center align-middle'>No</th>
                                    <th class='text-center align-middle'>Kode Guru</th>
                                    <th class='text-center align-middle'>Detail Guru ID</th>
                                    <th class='text-center align-middle'>Jumlah Pengawasan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($JumlahPengawasan as $index => $item)
                                    <tr class='text-center'>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->Guru)
                                                {{ $item->Guru->kode_guru }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->Guru)
                                                {{ $item->Guru->nama_guru }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $item->count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }} dan Pengawasan</h3>
                    </div>
                    <div class='card-body'>
                        <button id='BTNpdf' type='button' onclick='generatePDF()'
                            class='btn btn-default bg-success btn-md'> <i class='fa fa-file-pdf mr-2'></i>Export to PDF
                        </button>


                        <div id='divToExport' class='mt-1'>
                            <table class="table table-bordered text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th class='text-center align-middle' rowspan='2'>Tanggal</th>
                                        <th class='text-center align-middle' rowspan='2'>Mata Pelajaran</th>
                                        <th class='text-center align-middle' rowspan='2'>Jam</th>
                                        <th class='text-center align-middle' colspan='{{ $maxRuangan }}'>Ruang</th>
                                    </tr>
                                    @for ($i = 1; $i <= $maxRuangan; $i++)
                                        <th>{{ $i }}</th>
                                    @endfor
                                </thead>
                                <tbody>
                                    @if ($datas->isEmpty())
                                        <tr>
                                            <td colspan='4'>No data available in table</td>
                                        </tr>
                                    @else
                                        @foreach ($datas as $tanggal => $mapels)
                                            @php $rowspan = count($mapels); @endphp
                                            @foreach ($mapels as $mapelId => $jadwals)
                                                @php
                                                    $mapel = $jadwals->first()->mapel->mapel ?? 'Tidak Diketahui';
                                                    $jam = $jadwals->first()->jam_mulai ?? '-';

                                                @endphp
                                                <tr>
                                                    @if ($loop->first)
                                                        <td class='text-center align-middle not-editable'
                                                            rowspan="{{ $rowspan }}">
                                                            {{ Carbon::create($tanggal)->translatedformat('l, d F Y') }}
                                                        </td>
                                                    @endif
                                                    <td class="not-editable" data-id="{{ $jadwals->first()->id }}"
                                                        data-field="mapel">{{ $mapel }}</td>
                                                    <td class="not-editable" data-id="{{ $jadwals->first()->id }}"
                                                        data-field="jam">
                                                        {{ $jam }} - {{ $jam }}</td>

                                                    @for ($i = 1; $i <= $maxRuangan; $i++)
                                                        <td class="editable "
                                                            data-id="{{ $jadwals->where('nomor_ruangan', $i)->first()->id ?? '' }}"
                                                            data-field="detailguru_id">
                                                            @php
                                                                $jadwal = $jadwals->where('nomor_ruangan', $i)->first();
                                                            @endphp
                                                            {{ $jadwal->detailGuru->kode_guru ?? '' }}
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <script>
                            function generatePDF() {
                                // Ambil elemen yang ingin diekspor ke PDF
                                const element = document.getElementById('divToExport');

                                // Konfigurasi opsi untuk konversi HTML ke PDF
                                const options = {
                                    margin: [20, 10, 20, 10], // Menghapus margin untuk menghindari halaman kosong [atas, kanan, bawah, kiri]
                                    filename: 'Jadwal Pengawasan.pdf', // Nama file yang akan diunduh

                                    // Konfigurasi gambar dalam PDF
                                    image: {
                                        type: 'jpeg', // Format gambar dalam PDF
                                        quality: 0.98 // Kualitas gambar (0-1), semakin tinggi semakin bagus
                                    },

                                    // Pengaturan untuk html2canvas (digunakan untuk menangkap elemen HTML)
                                    html2canvas: {
                                        scale: 2, // Meningkatkan skala untuk meningkatkan kualitas hasil tangkapan
                                        scrollY: 0 // Mencegah efek scroll saat menangkap elemen
                                    },

                                    // Konfigurasi untuk jsPDF (library yang menangani pembuatan PDF)
                                    jsPDF: {
                                        unit: 'mm', // Menggunakan satuan milimeter
                                        format: 'legal', // Ukuran kertas yang digunakan (Legal: 216 × 356 mm)
                                        // format: [210, 400] // (Opsional) Custom ukuran kertas jika diperlukan
                                        orientation: 'landscape' // Mode orientasi PDF (portrait atau landscape)
                                    }
                                };

                                // Proses konversi elemen HTML menjadi PDF dan mengunduhnya
                                html2pdf().from(element).set(options).save();
                            }
                        </script>


                        <script>
                            $(document).ready(function() {
                                $(".editable").click(function() {
                                    let currentText = $(this).text().trim();
                                    let id = $(this).data("id");
                                    let field = $(this).data("field");

                                    if (!id) return;

                                    let input = $("<input>", {
                                        type: "text",
                                        value: currentText,
                                        class: "form-control"
                                    });

                                    $(this).html(input);
                                    input.focus();

                                    input.blur(function() {
                                        let newValue = $(this).val().trim();
                                        newValue = newValue.toUpperCase(); // Ubah nilai baru menjadi huruf kapital

                                        if (newValue !== currentText) {
                                            $.ajax({
                                                url: "/waka-kurikulum/jadwal-test/update",
                                                method: "POST",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    id: id,
                                                    field: field,
                                                    value: newValue,
                                                    kode_guru: newValue // Mengirimkan kode_guru yang sudah diubah ke server
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        input.parent().text(
                                                            newValue); // Ganti teks dengan nilai baru
                                                        checkDuplicates();
                                                    } else {
                                                        // Jika kode_guru tidak ditemukan, beri warna merah pada kolom tersebut
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Oops...',
                                                            text: response
                                                                .message, // Menampilkan pesan error
                                                        });

                                                        // Ganti warna teks menjadi merah menggunakan .css()
                                                        input.parent().css('color',
                                                            'red'
                                                        ); // Menambahkan warna merah secara langsung

                                                        input.parent().text(
                                                            currentText); // Mengembalikan nilai sebelumnya
                                                    }
                                                },
                                                error: function() {
                                                    input.parent().text(currentText);
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Gagal',
                                                        text: 'Gagal menyimpan data!',
                                                    });
                                                }
                                            });
                                        } else {
                                            input.parent().text(currentText);
                                        }


                                    });
                                });

                                function checkDuplicates() {
                                    $("tbody tr").each(function() {
                                        let values = [];
                                        $(this).find("td.editable").each(function() {
                                            let text = $(this).text().trim();
                                            if (values.includes(text) && text !== "-") {
                                                $(this).addClass("bg-danger text-white");
                                            } else {
                                                $(this).removeClass("bg-danger text-white");
                                                values.push(text);
                                            }
                                        });
                                    });
                                }

                                // Jalankan validasi saat halaman dimuat
                                checkDuplicates();
                            });
                        </script>




                    </div>
                </div>
                <div class='card'>


                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='BuatJadwal()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='BuatJadwal()'
 --}}

<script>
    function BuatJadwal(data) {
        var BuatJadwal = new bootstrap.Modal(document.getElementById('BuatJadwal'));
        BuatJadwal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BuatJadwal' tabindex='-1' aria-labelledby='LabelBuatJadwal' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelBuatJadwal'>
                    Tambah Data Test
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                @php
                @endphp
                {{-- <div class='form-group'>
                    <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                    @php
                        $dataruangs = range(1, 50);
                    @endphp
                    <label>Pilih Mapel</label>
                    <select id='select2-1' class='form-control' name='mapel_id' style='width: 100%;'>
                        <option value=''>--- Pillih Mapel ----</option>
                        @foreach ($DataMapels as $DataMapel)
                            <option value='{{ $DataMapel->mapel_id }}'>{{ $DataMapel->emengajartomapel->mapel }}
                            </option>
                        @endforeach
                    </select>
                    <div class='form-group'>
                        <label for='jam'>Jam Mulai</label>
                        <input type='time' class='form-control' id='jam' name='jam' placeholder='Jam Mulai'
                            required>
                    </div>
                    <div class='form-group'>
                        <label for='jumlah_ruang'>Jumlah Ruang</label>
                        <select name='jumlah_ruang' id='id' class='form-control' required>
                            <option value=''>--- Pilih Jumlah Ruang ---</option>
                            @foreach ($dataruangs as $jmruang)
                                <option value='{{ $jmruang }}'>{{ $jmruang }}
                                </option>
                            @endforeach
                    </div>
                    <div class='form-group'>
                        <label for='tanggal_pelaksanaan'>Tanggal Mulai</label>
                        <input type='text' class='form-control' id='tanggal_pelaksanaan' name='tanggal_pelaksanaan'
                            placeholder='Tanggal Mulai' required>
                    </div> --}}

                {{--
                <div class='form-group'>
                        <label for='detailguru_id'>Pengawas</label>
                        <select name='detailguru_id' id='pengawas_id' class='form-control' required>
                            <option value=''>--- Pilih Pengawas ---</option>
                            @foreach ($DataPengawas as $DataPengawasId)
                            <option value='{{ $DataPengawasId->id }}'>{{ $DataPengawasId->nama_guru }}
                            </option>
                        @endforeach
                        </select>
                    </div>
                     --}}
                {{-- </div> --}}
                <!-- Modal Create -->

                <form id='#id' action='{{ route('jadwal-test.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <form id="jadwalForm" action="{{ route('jadwal-test.store') }}" method="POST">
                        @csrf
                        <div id="row-container">
                            {{-- blade-formatter-disable --}}
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="tanggal_pelaksanaan">Tanggal Test</label>
                                    <input type="date" class="form-control" name="tanggal_pelaksanaan[]" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Pilih Mapel</label>
                                    <select class="form-control" name="mapel_id[]" style="width: 100%;">
                                        <option value="">--- Pilih Mata Pelajaran ----</option>
                                        @foreach ($DataMapels as $DataMapel)
                                            <option value="{{ $DataMapel->mapel_id }}">{{ $DataMapel->emengajartomapel->mapel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="durasi">Durasi</label>
                                    <input type="number" class="form-control durasi-input" name="durasi[]" min="30" value="90" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="time">Waktu : <span class="waktu-hasil text-muted">07:30 - 08:00</span></label>
                                    <input type="time" class="form-control time-input" name="time[]" value="07:30" required>
                                    <span><b>* Pagi : <span class="text-success">AM</span> </b><br>
                                        <b>* Siang : <span class="text-primary">PM</span> </b>
                                    </span>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="nomor_ruangan">Jml Ruangan</label>
                                    <input type="number" class="form-control" name="nomor_ruangan[]" min="1" value="1">
                                </div>
                                <div class="col-md-1 d-flex align-items-start justify-content-center">
                                    <button type="button" class="btn btn-danger remove-row mt-4">  <i class="fa fa-minus"></i> </button>
                                </div>
                            </div>

                            {{-- blade-formatter-enable --}}
                        </div>

                        <button type="button" class="btn btn-success add-row">Tambah Row</button>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                let container = document.querySelector("#row-container");
                                let addButton = document.querySelector(".add-row");

                                addButton.addEventListener("click", function() {
                                    let newRow = document.createElement("div");
                                    newRow.classList.add("form-row");

                                    newRow.innerHTML = `<hr class="bg-dark" style="height: 2px;">
                                                        <div class="form-group col-md-2">
                                                            <label for="tanggal_pelaksanaan">Tanggal Test</label>
                                                            <input type="date" class="form-control" name="tanggal_pelaksanaan[]" required>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>Pilih Mapel</label>
                                                            <select class="form-control" name="mapel_id[]" style="width: 100%;">
                                                                <option value="">--- Pilih Mata Pelajaran ----</option>
                                                                @foreach ($DataMapels as $DataMapel)
                                                                    <option value="{{ $DataMapel->mapel_id }}">
                                                                        {{ $DataMapel->emengajartomapel->mapel }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <label for="durasi">Durasi</label>
                                                            <input type="number" class="form-control durasi-input" name="durasi[]" min="30" value="90" required>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label for="time">Waktu  : <span class="waktu-hasil text-muted">07:30 - 08:00</span></label>
                                                            <input type="time" class="form-control time-input" name="time[]" value="07:30" required>
                                                            <p><b>* Pagi : <span class="text-success">AM</span> </b><br>
                                                            <b>* Siang : <span class="text-primary">PM</span> </b></p>
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label for="nomor_ruangan">Jml Ruangan</label>
                                                            <input type="number" class="form-control" name="nomor_ruangan[]" min="1" value="1">
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-start justify-content-center">
                                                            <button type="button" class="btn btn-danger remove-row mt-4">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    `;

                                    container.appendChild(newRow);
                                    addRemoveEvent(newRow);
                                    updateTime(newRow);
                                });

                                function addRemoveEvent(row) {
                                    row.querySelector(".remove-row").addEventListener("click", function() {
                                        row.remove();
                                    });
                                }

                                function updateTime(row) {
                                    row.querySelector(".time-input").addEventListener("input", function() {
                                        calculateEndTime(row);
                                    });

                                    row.querySelector(".durasi-input").addEventListener("input", function() {
                                        calculateEndTime(row);
                                    });
                                }

                                function calculateEndTime(row) {
                                    let startTime = row.querySelector(".time-input").value;
                                    let duration = row.querySelector(".durasi-input").value;
                                    let resultDisplay = row.querySelector(".waktu-hasil");

                                    if (startTime && duration) {
                                        let [hour, minute] = startTime.split(":").map(Number);
                                        let endTime = new Date();
                                        endTime.setHours(hour);
                                        endTime.setMinutes(minute + parseInt(duration));

                                        let formattedEndTime = endTime.toTimeString().slice(0, 5); // Format HH:MM
                                        resultDisplay.textContent = `${startTime} - ${formattedEndTime}`;
                                    }
                                }

                                document.querySelectorAll(".time-input, .durasi-input").forEach(input => {
                                    input.addEventListener("input", function() {
                                        let row = input.closest(".form-row");
                                        calculateEndTime(row);
                                    });
                                });

                                // Panggil saat halaman dimuat
                                document.querySelectorAll(".form-row").forEach(row => {
                                    updateTime(row);
                                });
                            });
                        </script>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                            <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                        </div>
                    </form>


                </form>

            </div>
        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='CekKode()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='CekKode()'
 --}}

<script>
    function CekKode(data) {
        var CekKode = new bootstrap.Modal(document.getElementById('CekKode'));
        CekKode.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='CekKode' tabindex='-1' aria-labelledby='LabelCekKode' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelCekKode'>
                    Liaht Kode Guru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='text-center align-middle'>
                            <th>ID</th>
                            <th>Nama Guru</th>
                            <th>Kode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataPengawas as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_guru }}</td>
                                <td>{{ $data->kode_guru }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center align-middle'>
                            <th>ID</th>
                            <th>Nama Guru</th>
                            <th>Kode</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='HapusMapel()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='HapusMapel()'
 --}}

<script>
    function HapusMapel(data) {
        var HapusMapel = new bootstrap.Modal(document.getElementById('HapusMapel'));
        HapusMapel.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='HapusMapel' tabindex='-1' aria-labelledby='LabelHapusMapel' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelHapusMapel'>
                    Hapus Data Pelajaran
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id="delete-form" action="" method="POST">
                    @csrf
                    @method('DELETE') <!-- Spoofing DELETE method -->

                    <input type="hidden" name="mapel_id" id="mapel-id">

                    <div class='form-group'>
                        <label>Pilih Mapel</label>
                        <select id='select2-x' class='form-control' name='mapel_id' style='width: 100%;' required>
                            <option value=''>--- Pilih Mapel ----</option>
                            @foreach ($DataMapelTest as $DataMapel)
                                <option value='{{ $DataMapel->mapel_id }}'
                                    data-url="{{ route('jadwal-test.destroy', $DataMapel->mapel_id) }}">
                                    {{ $DataMapel->Mapel->mapel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-danger'><i class='fa fa-trash'></i> Delete</button>
                    </div>
                </form>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById('select2-x').addEventListener('change', function() {
                        let selectedOption = this.options[this.selectedIndex];
                        let deleteForm = document.getElementById('delete-form');

                        if (selectedOption.value) {
                            deleteForm.action = selectedOption.dataset.url;
                        } else {
                            deleteForm.action = "";
                        }
                    });
                });
            </script>


        </div>
    </div>

</div>
