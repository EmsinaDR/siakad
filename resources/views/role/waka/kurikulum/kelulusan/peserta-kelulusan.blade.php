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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='Lulus()'> <i class='fa fa-plus'></i> Tambah Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='BulkKelulusan()'> <i class='fa fa-plus'></i> Status Kelulusan</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='SetTanggalPengumuman()'> <i class='fa fa-plus'></i> Tanggal Pengumuman</button>
                    <form id="resetForm" action="{{ route('reset.peserta.kelulusan') }}" method="POST">
                        @csrf
                        @method('POST')
                    </form>

                    <button type="button" class="btn btn-block btn-default bg-danger btn-md" onclick="confirmReset()">
                        <i class="fa fa-recycle"></i> Reset Data
                    </button>

                    <script>
                        function confirmReset() {
                            Swal.fire({
                                title: "Apakah Anda yakin?",
                                text: "Data status kelulusan akan direset dan tidak bisa dikembalikan!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#d33",
                                cancelButtonColor: "#3085d6",
                                confirmButtonText: "Ya, Reset!",
                                cancelButtonText: "Batal"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById("resetForm").submit();
                                }
                            });
                        }
                    </script>

                </div>
                <div class='col-xl-10'>
                    <table id='example1x' width='100%' class='table table-responsive table-bordered table-hover'>
                        @php
                        $cekInformasi = $datas->first()
                        @endphp
                        <tbody>
                            <tr>
                                <td>Jam</td>
                                <td class='text-left'>{{$cekInformasi->tanggal_pengumuman ? Carbon::create($cekInformasi->tanggal_pengumuman)->translatedformat('H:i'): 'Belum Ditetapkan'}}</td>
                            </tr>
                            <tr>
                                <td class='text-left'>Tanggal</td>
                                <td class='text-left'>{{$cekInformasi->tanggal_pengumuman ? Carbon::create($cekInformasi->tanggal_pengumuman)->translatedformat('l, d F Y'): 'Belum Ditetapkan'}}</td>
                            </tr>
                            <tr>
                                <td class='text-left'>Jumlah Lulus</td>
                                <td class='text-left'>{{$datas->where('status_kelulusan', 'lulus')->count()}} Siswa</td>
                            </tr>
                            <tr>
                                <td class='text-left'>Jumlah Pending</td>
                                <td class='text-left'>{{$datas->where('status_kelulusan', 'pending')->count()}} Siswa</td>
                            </tr>
                            <tr>
                                <td class='text-left'>Jumlah Tidak Lulus</td>
                                <td class='text-left'>{{$datas->where('status_kelulusan', 'tidak lulus')->count()}} Siswa</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
            {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        {{-- Catatan :
                          - Include Komponen Modal CRUD + Javascript / Jquery
                          - Perbaiki Onclick Tombol Modal Create, Edit
                          - Variabel Active Crud menggunakan ID User
                           --}}
                        <table id='example1' width='100%' style='align:center'
                            class='table table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th id='noprint'>Action</th>
                                    {{-- @if ($activecrud === 1)
                                                {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center'>
                                            @if (empty($data->status_kelulusan))
                                            @elseif($data->status_kelulusan === 'pending')
                                                <span class="bg-warning p-2">Pending</span>
                                            @elseif($data->status_kelulusan === 'tidak lulus')
                                                <span class="bg-danger p-2">Tidak Lulus</span>
                                            @else
                                                <span class="bg-success p-2">Lulus</span>
                                            @endif
                                        </td>
                                        <td class='text-center'>
                                            {{ $data->tahun_lulus }}
                                        </td>

                                        <td id='noprint' width='10%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                @if ($data->status_kelulusan === 'Lulus')
                                                    <button type='button'
                                                        class='btn btn-success btn-sm btn-equal-width mx-1'
                                                        onclick='confirmDelete({{ $data->id }})'>
                                                        <i class='fa fa-file-pdf'></i>
                                                    </button>
                                                @endif

                                                <button type='button'
                                                    class='btn btn-warning btn-sm btn-equal-width mx-1'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                    <i class='fa fa-edit'></i>
                                                </button>

                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}'
                                                    action='{{ route('peserta-kelulusan.destroy', $data->id) }}'
                                                    method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <button type='button'
                                                    class='btn btn-danger btn-sm btn-equal-width mx-1'
                                                    onclick='confirmDelete({{ $data->id }})'>
                                                    <i class='fa fa-trash'></i>
                                                </button>
                                            </div>

                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('update.peserta.kelulusan', ['id' => $data->id]) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('POST')
                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='status'>Data Status Kelulusan</label>
                                                                <select name='status_kelulusan' id='select2-{{ $data->id }}' class='form-control' required>
                                                                    <option value=''>--- Pilih Data Status  Kelulusan ---</option>
                                                                    <option value='pending'>Pending</option>
                                                                    <option value='lulus'>Lulus</option>
                                                                    <option value='tidak lulus'>Tidak Lulus</option>
                                                                </select>

                                                            </div>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                                    $('#select2-{{ $data->id }}').val(@json($data->status_kelulusan)).trigger(
                                                                        'change'); // Mutiple Select Select value in array json
                                                                });
                                                            </script>
                                                            <div class='form-group'>
                                                                @php
                                                                    $tahuns = range(date('Y') - 4, date('Y'));
                                                                @endphp
                                                                <label for='tahun_lulus'>Tahun Lulus</label>
                                                                <select name='tahun_lulus' id='id' class='form-control' required>
                                                                    <option value=''>--- Pilih Tahun Lulus --- </option>
                                                                    @foreach ($tahuns as $tahun)
                                                                        <option value="{{ $tahun }}" {{ $data->tahun_lulus == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>

                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                                            {{-- blade-formatter-enable --}}
                                                        </form>

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}
                                            {{-- Modal View --}}

                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='ViewModalLabel' aria-hidden='true'>


                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                    <section>
                                                        //Content View
                                                    </section>
                                                </x-view-modal>
                                            </div>
                                            {{-- Modal View Akhir --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- @if ($activecrud === 1) --}}
                                    <th id='noprint' class='text-center'>Action</th>
                                    {{-- @endif --}}
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

<script>
    function BulkKelulusan(data) {
        var BulkKelulusan = new bootstrap.Modal(document.getElementById('BulkKelulusan'));
        BulkKelulusan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BulkKelulusan' tabindex='-1' aria-labelledby='BulkKelulusan' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='BulkKelulusan'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='#id' action='{{ route('status.peserta.kelulusan') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <div class="form-group">
    <label>Data Siswa</label>
    <div style="margin-bottom: 10px;">
        <input type="checkbox" id="pilih_semua"> <strong>Pilih Semua</strong>
    </div>

    <select id="detailsiswa_id" class="select2" name="detailsiswa_id[]" multiple="multiple" data-placeholder="Pilih Siswa" style="width: 100%;">
        <option value="">--- Pilih Siswa ----</option>
        @foreach ($Siswas->where('tingkat_id', 9) as $siswa)
            <option value="{{ $siswa->id }}">{{ $siswa->KelasOne->kelas }} - {{ $siswa->nama_siswa }}</option>
        @endforeach
    </select>

    <!-- Tempat hidden input kalau pilih semua -->
    <div id="hidden-inputs"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pilihSemua = document.getElementById('pilih_semua');
        const selectSiswa = document.getElementById('detailsiswa_id');
        const hiddenInputs = document.getElementById('hidden-inputs');

        pilihSemua.addEventListener('change', function () {
            if (this.checked) {
                // Disable select multiple
                selectSiswa.disabled = true;
                hiddenInputs.innerHTML = ''; // kosongkan dulu

                // Ambil semua option siswa (kecuali yang kosong)
                const options = selectSiswa.querySelectorAll('option');
                options.forEach(option => {
                    if (option.value !== '') {
                        hiddenInputs.innerHTML += `<input type="hidden" name="detailsiswa_id[]" value="${option.value}">`;
                    }
                });
            } else {
                // Enable select multiple lagi
                selectSiswa.disabled = false;
                hiddenInputs.innerHTML = ''; // bersihkan hidden inputs
            }
        });
    });
</script>

                    <div class='form-group'>
                        <label for='status'>Data Status Kelulusan</label>
                        <select name='status_kelulusan' id='select2-{{ $data->id }}' class='form-control' required>
                            <option value=''>--- Pilih Data Status Kelulusan ---</option>
                            <option value='Pending'>Pending</option>
                            <option value='Lulus'>Lulus</option>
                            <option value='Tidak Lulus'>Tidak Lulus</option>
                        </select>
                    </div>
                    <div class='form-group'>
                        @php
                            $tahuns = range(date('Y') - 4, date('Y'));
                        @endphp
                        <label for='tahun_lulus'>Tahun Lulus</label>
                        <select name='tahun_lulus' id='id' class='form-control' required>
                            <option value=''>--- Pilih Tahun Lulus ---</option>
                            @foreach ($tahuns as $tahun)
                                <option value='{{ $tahun }}'> {{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
                {{-- blade-formatter-enable --}}
            </div>

        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='SetTanggalPengumuman()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='SetTanggalPengumuman()'
 --}}

<script>
    function SetTanggalPengumuman(data) {
        var SetTanggalPengumuman = new bootstrap.Modal(document.getElementById('SetTanggalPengumuman'));
        SetTanggalPengumuman.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='SetTanggalPengumuman' tabindex='-1' aria-labelledby='LabelSetTanggalPengumuman'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelSetTanggalPengumuman'>
                    Tanggal Pengumuman
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form action="{{ route('tanggal.kelulusan') }}" method="POST">
                    @csrf
                    <div class='form-group'>
                        <label for="tanggal_pengumuman">Tanggal dan Waktu Pengumuman:</label>
                        <input type="datetime-local" id="tanggal_pengumuman" name="tanggal_pengumuman"
                            class='form-control' required>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</div>
@php
    /* Title Export */
    $Judul = 'Data Kelulusan Siswa';

    //Format Image to Logo
    $filePath = public_path('img/logo.png'); // Path file di folder public
    // Membaca konten file sebagai string
    $fileContents = File::get($filePath);
    // Mengubah konten file menjadi Base64
    $fileBase64 = base64_encode($fileContents);
    // Menambahkan prefix untuk tipe file (misalnya untuk gambar JPEG)
    $mimeType = mime_content_type($filePath); // Mengetahui tipe MIME file
    $fileBase64WithPrefix = 'data:' . $mimeType . ';base64,' . $fileBase64;
    $hariIni = Carbon::now()->isoFormat('dddd, D MMMM YYYY');
@endphp
<script>
    $(document).ready(function() {
        $('#example1').DataTable().destroy();
        $('#example1').DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: true,
            buttons: ['copy', 'excel', {
                    // extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'potrait',
                    pageSize: 'A4',
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':visible:not(:last-child)' // Mengabaikan kolom Action saat ekspor
                    },

                    customize: function(doc) {
                        // Hapus title default DataTables

                        doc.content.splice(0, 1);

                        doc.content.unshift({
                            text: `Nama 					: Dany
                                    Kelas 					 : XI A
                                    Tanggal 				: {{ $hariIni }} `,

                            fontSize: 12,
                            margin: [0, 20, 0,
                                10
                            ], // margin: [right, top, bottom, left]
                            lineHeight: 1.5 // menambahkan jarak antar baris teks
                        });
                        doc.content[1].table.body.forEach(function(row) {
                            row.pop(); // Hanya menghapus kolom terakhir (kolom Action)
                        });
                        doc.content[1].table.widths = [
                            50, // Lebar kolom pertama (ID atau Nomor)
                            '*', // Lebar kolom kedua dan seterusnya secara dinamis
                            '*', // Sesuaikan kolom lain
                            '*', // Sesuaikan kolom lain
                        ];
                        // Tambahkan informasi tambahan
                        doc.content.unshift({
                            text: '\n{{ $Judul }}\n',
                            fontSize: 14,
                            bold: true,
                            alignment: 'center',
                            decoration: 'underline', // Menambahkan garis bawah
                            margin: [0, 10, 0, 10]
                        });

                        // Data Logo
                        // Gunakan gambar dalam bentuk Base64
                        var logoBase64 = @json($fileBase64WithPrefix); // Masukkan Base64 logo
                        // Tambahkan garis pemisah (Line)
                        doc.content.unshift({
                            canvas: [{
                                type: 'line',
                                x1: 0,
                                y1: 10,
                                x2: 515,
                                y2: 10,
                                lineWidth: 1
                            }]
                        });
                        // Tambahkan Logo dan Kop Surat
                        doc.content.unshift({
                            columns: [{
                                    image: logoBase64, // Pakai Base64
                                    width: 80,
                                    margin: [0, 0, 10, 0]
                                },
                                {
                                    stack: [{
                                            text: 'SEKOLAH XYZ',
                                            fontSize: 16,
                                            bold: true,
                                            alignment: 'center'
                                        },
                                        {
                                            text: 'Jl. Pendidikan No. 123, Kota ABC',
                                            fontSize: 12,
                                            alignment: 'center'
                                        },
                                        {
                                            text: 'Telp: (021) 12345678 | Email: info@sekolahxyz.com',
                                            fontSize: 10,
                                            alignment: 'center'
                                        }
                                    ],
                                    width: '70%'
                                }
                            ],
                            columnGap: 10
                        });
                        // Data Logo



                    }
                },

                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:not(#noprint)' // Mengabaikan kolom dengan ID noprint saat ekspor
                    },
                    customize: function(win) {
                        // Menghapus kolom dengan ID noprint saat print

                        $(win.document.body).find('table').find('thead').find('tr').find(
                            'th#noprint').remove();
                        $(win.document.body).find('table').find('tbody').find('tr').each(
                            function() {
                                $(this).find('td#noprint').remove();
                            });

                        var logoBase64 = @json($fileBase64WithPrefix); // Masukkan Base64 logo

                        // Menambahkan style khusus untuk halaman print agar tetap terpusat
                        var style = $('<style>@media print { ' +
                            'body { font-family: Arial, sans-serif; margin: 0; padding: 0; } ' +
                            'table { width: 100% !important; margin-left: auto !important; margin-right: auto !important; border-collapse: collapse !important; table-layout: auto !important; } ' +
                            'th { text-align: center !important; vertical-align: middle !important; padding: 8px !important; border: 1px solid #000 !important; } ' +
                            'td { text-align: center !important; vertical-align: middle !important; padding: 8px !important; border: 1px solid #000 !important; } ' +
                            'td.text-left { text-align: left !important; } ' +
                            'td:nth-child(2) { text-align: left !important; } ' +
                            // Kolom kedua (Nama) agar teksnya rata kiri
                            '} </style>');
                        $(win.document.head).append(style);




                        // Menghapus judul default dari DataTables (biasanya ada di posisi pertama)
                        $(win.document.body).find('h1').remove();

                        // Menambahkan judul kustom di atas tabel
                        var title =
                            `<div style='text-align: center; font-size: 18px; font-weight: bold; margin-bottom: 20px;'>{{ $Judul }}</div>`;
                        var description = `
                                <div style='text-align: left; font-size: 14px; margin-bottom: 10px; line-height: 1.6;'>
                                    <div style='display: flex; margin-bottom: 5px;'>
                                        <div style='flex-basis: 100px; font-weight: bold;'>Nama</div>
                                        <div>: John Doe</div>
                                    </div>
                                    <div style='display: flex; margin-bottom: 5px;'>
                                        <div style='flex-basis: 100px; font-weight: bold;'>Kelas</div>
                                        <div>: 12A</div>
                                    </div>
                                    <div style='display: flex; margin-bottom: 5px;'>
                                        <div style='flex-basis: 100px; font-weight: bold;'>Tanggal:</div>
                                        <div>: {{ date('Y') }}</div>
                                    </div>
                                </div>`;



                        // Memasukkan judul dan keterangan di atas tabel
                        $(win.document.body).prepend(description);
                        $(win.document.body).prepend(title);


                        // Memastikan tabel tetap terpusat
                        $(win.document.body).find('table').css({
                            'width': '100% !important', // Lebar tabel 100%
                            'margin-left': 'auto !important', // Margin kiri otomatis untuk centering
                            'margin-right': 'auto !important', // Margin kanan otomatis untuk centering
                            'border-collapse': 'collapse !important', // Menghindari gap antar cell tabel
                            'table-layout': 'auto !important' // Agar tabel menyesuaikan dengan konten
                        });
                    }
                },

            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>
