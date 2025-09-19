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
                    <!-- Tombol Tambah Data -->
                    {{-- blade-formatter-disable --}}
                    <button type="button" class="btn btn-block btn-default bg-primary btn-md" id="btnTambah"><i class="fa fa-plus"></i> Mulai</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='CekKode()'> <i class='fa fa-eye'></i> Lihat Kode Guru</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' id="btnDuplikat"> <i class='fa fa-copy'></i> Duplikat</button>
                    {{-- blade-formatter-enable --}}

                    <!-- Load SweetAlert (CDN) -->
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                        document.getElementById('btnTambah').addEventListener('click', function() {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: "Apakah Anda yakin ingin membuat blanko jadwal karena akan menghapus semua data jadwal pelajaran saat ini?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Lanjutkan',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('jadwal.blanko') }}";
                                }
                            });
                        });
                        document.getElementById('btnDuplikat').addEventListener('click', function() {
                            Swal.fire({
                                title: 'Konfirmasi',
                                text: "Apakah Anda yakin menduplikasi jadwal sebelumnya?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Lanjutkan',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "{{ route('jadwal.duplikat') }}";
                                }
                            });
                        });
                    </script>

                </div>
                <div class='col-xl-10'>

                    @if (empty($CekJadwal))
                        <div class='card'>
                            <div class='card-header bg-warning'>
                                <h3 class='card-title'><i class='fas fa-text-width mr-2'></i><b>Cara Penggunaan</b></h3>
                            </div><!-- /.card-header -->
                            <div class='card-body'>
                                <dl>
                                    <dt>Langkah 1</dt>
                                    <dd>Siapkan yang diperlukan sebelum memulai disini</dd>
                                    <dd>Data Emengajar, Ekelas sudah terisi dengan baik karena data akan diambil sesuai
                                        database teserbut</dd>
                                    <hr>
                                    <dt>Langkah 2</dt>
                                    <dd>Tekan Tombol Mulai</dd>
                                    <dd>Setelah menekan <b class="text-success">Tombol Mulai</b> informasi ini akan
                                        tidak
                                        terlihat dan berubah menjadi
                                        data jadwal berisi jam ke 1 - selesai, kelas berdasarkan kelas tersedia</dd>
                                    <dd>Tabel pemetaan guru mengajar akan tersedia jika sudah memulai untuk membantu
                                        dalam
                                        pembuatan jadwal</dd>
                                    <hr>
                                    <dt>Langkah 3</dt>
                                    <dd>Kilik data kosong dan masukkan sesuai guru mengajar <b
                                            class="text-success">(kode
                                            guru mengajar)</b> data harus sesuai pedoman tabel Bantu</dd>
                                    <dd>Jika terjadi kesalahan atau bentrok di jam sama, akan ada konfirmasi jika tidak
                                        ada
                                        bisa refresh halaman dengan menekan <b class="text-success">F5</b> pada keyborad
                                    </dd>
                                    <hr>
                                    <dt>Terkait Tombol</dt>
                                    <dd>Tombol Mulai untuk memulai dan menyiapkan data sesuai dengan database tersedia
                                    </dd>
                                    <dd>Tombol Lihat Kode Guru : Hanya untuk melihat kode guru, karena ada tabel
                                        pemetaan pda Tabel bantu bisa digunakan jika data tersebut tidak ada tabel bantu
                                        dan dapat diartikan kode tersebut ada kesalahan dalam mengisi database Emengajar
                                    </dd>
                                    <dd>Tombol Duplikat : Untuk menggandakan jadwal karena sifat jadwal persemester,
                                        jadi jika tidak ada perubahan bisa langsung duplikat atau menggandakan jadwal
                                        sebelumnya</dd>
                                </dl>
                            </div><!-- /.card-body -->
                        </div>
                    @else
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Tabel Bantu Jurnal Mengajar</h3>
                        </div>
                        @if ($emengajars->isEmpty())
                            <div class="alert alert-danger text-center">
                                Data tidak ditemukan.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table id='example1' class="table table-bordered table-striped table-hover">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>Mapel</th>
                                            @foreach ($dataKelas as $kelasId)
                                                @php
                                                    $NamaKelas = \App\Models\Admin\Ekelas::where(
                                                        'id',
                                                        $kelasId,
                                                    )->first();
                                                @endphp
                                                <th>{{ $NamaKelas->kelas }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($emengajars as $item)
                                            <tr>
                                                {{-- blade-formatter-disable --}}
                                                @php
                                                $CekJTM = App\Models\Admin\Emapel::where('mapel', $item['mapel'])->first();
                                                @endphp
                                               {{-- blade-formatter-enable --}}
                                                <td width='20%' class="fw-bold">
                                                    {{ $item['mapel'] }} {{ $CekJTM->jtm }}
                                                </td>
                                                @foreach ($dataKelas as $kelasId)
                                                    {{-- blade-formatter-disable --}}
                                                     @php
                                                     $etapels = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                                                     $KodeGuru = App\Models\User\Guru\Detailguru::where('kode_guru', $item['kelas_' . $kelasId])->first();
                                                     $CekJumlah = App\Models\Jadwal\JadwalPelajaran::where('detailguru_id', $KodeGuru->id)->where('tapel_id', $etapels->id)->where('kelas_id', $kelasId)->count();
                                                     $CekJTM = App\Models\Admin\Emapel::where('mapel', $item['mapel'])->first();
                                                     @endphp
                                                    {{-- blade-formatter-enable --}}
                                                    <td class="text-center">{{ $item['kelas_' . $kelasId] ?? '-' }}
                                                        @if ($CekJumlah !== 0)
                                                            @if ($CekJumlah <= $CekJTM->jtm)
                                                                / <b class="text-success">{{ $CekJumlah }}</b>
                                                            @else
                                                                / <b class="text-danger">{{ $CekJumlah }}</b>
                                                            @endif
                                                    </td>
                                                @else
                                                @endif
                                        @endforeach
                                        </tr>
                        @endforeach
                        </tbody>
                        </table>
                </div>
                @endif


            </div>

            @endif
        </div>


        <div class='ml-2 my-4'>
            <div class="card">
                @if (empty($CekJadwal))
                @else
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Jadwal Pelajaran</h3>
                    </div>
                    <div class='card-body'>
                        <h2 class="text-center mb-4">Jadwal Pelajaran</h2>

                        <div class="row">
                            @foreach ($jadwals as $hari => $jadwalHari)
                                @if ($kelasList < 8)
                                    <div class="col-6 mb-4 shadow-sm">
                                    @else
                                        <div class="col-12 mb-4 shadow-sm">
                                @endif
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">{{ strtoupper($hari) }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Jam</th>
                                                    @foreach ($kelasList as $kelasId)
                                                        @php
                                                            $NamaKelas = \App\Models\Admin\Ekelas::where(
                                                                'id',
                                                                $kelasId,
                                                            )->first();
                                                        @endphp
                                                        <th class="text-center">{{ $NamaKelas->kelas }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jadwalHari as $jam => $jadwalKelas)
                                                    @php
                                                        $kodeGuruSet = [];
                                                        $bentrok = false;
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center fw-bold">{{ $jam }}</td>
                                                        @foreach ($kelasList as $kelasId)
                                                            @php
                                                                $jadwal = $jadwalKelas
                                                                    ->where('kelas_id', $kelasId)
                                                                    ->first();
                                                                $kodeGuru =
                                                                    $jadwal && $jadwal->guru
                                                                        ? $jadwal->guru->kode_guru
                                                                        : '';

                                                                // Cek apakah kode guru sudah ada di array
                                                                if ($kodeGuru && in_array($kodeGuru, $kodeGuruSet)) {
                                                                    $bentrok = true;
                                                                } else {
                                                                    $kodeGuruSet[] = $kodeGuru;
                                                                }
                                                            @endphp
                                                            <td class="text-center editable {{ $bentrok && $kodeGuru ? 'bg-danger text-white' : '' }}"
                                                                data-id="{{ $jadwal ? $jadwal->id : '' }}"
                                                                data-kelas="{{ $jadwal && $jadwal->Kelas ? $jadwal->Kelas->kelas : '' }}"
                                                                data-kode-guru="{{ $kodeGuru }}">
                                                                <span class="p-2">{{ $kodeGuru ?: '-' }}</span>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                @endforeach
                @endif
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".editable").forEach(td => {
                        td.addEventListener("click", function() {
                            let currentText = this.textContent.trim();
                            let input = document.createElement("input");
                            input.type = "text";
                            input.value = currentText.toUpperCase(); // Otomatis uppercase saat edit
                            input.style.width = "100%";
                            this.innerHTML = "";
                            this.appendChild(input);
                            input.focus();

                            input.addEventListener("input", function() {
                                this.value = this.value
                                    .toUpperCase(); // Konversi ke uppercase real-time
                            });

                            input.addEventListener("blur", function() {
                                let newValue = this.value.trim();
                                let jadwalId = td.getAttribute("data-id");

                                if (newValue !== currentText && jadwalId) {
                                    fetch(`/waka-kurikulum/update-jadwal/${jadwalId}`, {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": document.querySelector(
                                                    'meta[name="csrf-token"]').getAttribute(
                                                    "content"),
                                            },
                                            body: JSON.stringify({
                                                kode_guru: newValue
                                            }),
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire({
                                                    icon: "success",
                                                    title: "Berhasil!",
                                                    text: "Data berhasil diperbarui.",
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                });
                                                td.innerHTML =
                                                    `<span class="p-2">${newValue}</span>`;
                                                td.setAttribute("data-kode-guru", newValue);
                                            } else {
                                                Swal.fire({
                                                    icon: "error",
                                                    title: "Gagal!",
                                                    text: data.message
                                                });
                                                td.innerHTML =
                                                    `<span class="p-2">${currentText}</span>`;
                                            }
                                        })
                                        .catch(error => {
                                            console.error("❌ Error Fetch:", error);
                                            Swal.fire({
                                                icon: "error",
                                                title: "Terjadi Kesalahan!",
                                                text: "Gagal memperbarui data."
                                            });
                                            td.innerHTML =
                                                `<span class="p-2">${currentText}</span>`;
                                        });
                                } else {
                                    td.innerHTML = `<span class="p-2">${currentText}</span>`;
                                }
                            });
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
<style>
    .dt-button-collection {
        z-index: -1050 !important;
        position: absolute !important;
        display: block !important;
    }
</style>
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            destroy: true,
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            searching: true,
            buttons: ['copy', 'excel', 'pdf', 'print'],
            rowGroup: {
                dataSrc: 0
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(document).ready(function() {
    // $('.example2').each(function() {
    //     let table = $(this).DataTable({
    //         destroy: true,
    //         responsive: true,
    //         lengthChange: true,
    //         autoWidth: false,
    //         searching: true,
    //         buttons: ['copy', 'excel', 'pdf', 'print'],
    //         rowGroup: {
    //             dataSrc: 0
    //         }
    //     });

    //     let wrapper = $(this).closest('.dataTables_wrapper');
    //     table.buttons().container().appendTo(wrapper.find('.col-md-6:eq(0)'));
    // });
});

</script>
