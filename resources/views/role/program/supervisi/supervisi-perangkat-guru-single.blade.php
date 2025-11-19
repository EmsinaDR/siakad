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
                        <h3 class="text-center"><b>INSTRUMEN PENILAIAN PERANGKAT PEMBELAJARAN</b></h3>
                        <h3 class="text-center"><b>TAHUN PELAJARAN {{ $Tapels->tapel }}/ {{ $Tapels->tapel + 1 }}</b>
                        </h3>
                        <hr class='bg-light' style='height: 3px;'>

                        <div class="row">
                            <div class="col-xl-6">
                                <table id='example1' width='100%' class='table table-bordered'>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Nama Sekolah</td>
                                        <td class='text-left'> : {{ $Identitas->jenjang }}{{ $Identitas->nomor }}
                                            {{ $Identitas->namasek }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Nama Guru</td>
                                        <td class='text-left'> : {{ $Guru->nama_guru }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>NIP/NUPTK</td>
                                        <td class='text-left'> : {{ $Guru->nip }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Sertifikasi</td>
                                        <td class='text-left'> : Tahun {{ request()->detailguru_id }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran di Sekolah</td>
                                        <td class='text-left'> : .......... hari/minggu ........ %</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran Tatap Muka di kelas</td>
                                        <td class='text-left'> : .......... %</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-6">
                                <table id='example1' width='100%' class='table table-bordered'>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Tahun Pelajaran</td>
                                        <td class='text-left'> : {{ $Tapels->tapel }}/ {{ $Tapels->tapel + 1 }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Mata Pelajaran</td>
                                        <td class='text-left'> : {{ $DataMapel->mapel }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kelas/Semester</td>
                                        <td class='text-left'> : {{ $DataKelas->kelas }} / {{ $Tapels->semester }}
                                        </td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Jumlah Jam TM</td>
                                        <td class='text-left'> : {{ $DataMapel->jtm }} / minggu</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran di Sekolah</td>
                                        <td class='text-left'> : ............. </td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Kehadiran Tatap Muka di kelas</td>
                                        <td class='text-left'> : .............</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {{-- blade-formatter-disable --}}
                        <table id="example1x" width="100%" class="table table-bordered table-hover">
                            <thead>
                                <tr class='table-success'>
                                    <th width='1%' class="text-center align-middle" rowspan="2">ID</th>
                                    <th class="text-center align-middle" rowspan="2">Indikator</th>
                                    <th class="text-center align-middle" colspan="3">Penilaian</th>
                                    <th class="text-center align-middle" rowspan="2">Keterangan</th>
                                </tr>
                                <tr class='table-success'>
                                    <th width='10%' class="text-center">Tidak Ada</th>
                                    <th width='10%' class="text-center">Ada dan Tidak Sesuai</th>
                                    <th width='10%' class="text-center">Ada dan Sesuai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Instrumens as $kategori => $indikatorList)
                                    @foreach ($indikatorList as $indikator)
                                        @php
                                            $kode = substr($indikator->nilai, 0, 1); // Ambil angka pertama sebagai kode posisi
                                            $nilai = substr($indikator->nilai, 1); // Sisanya sebagai nilai input
                                        @endphp
                                        <tr data-id="{{ $indikator->id }}">
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td>{{ $indikator->indikator }}</td>

                                            <td class="editable
                                                text-center align-middle"
                                                data-kode="1">
                                                {{ $kode == 1 ? $nilai : 0 }}
                                            </td> <!-- Tidak Ada -->
                                            <td class="editable text-center align-middle" data-kode="2">
                                                {{ $kode == 2 ? $nilai : 0 }}
                                            </td> <!-- Ada dan Tidak Sesuai -->
                                            <td class="editable text-center align-middle" data-kode="3">
                                                {{ $kode == 3 ? $nilai : 0 }}
                                            </td> <!-- Ada dan Sesuai -->

                                            <td class="editable-keterangan">
                                                {{ $indikator->keterangan ?? '-' }}
                                            </td> <!-- Keterangan -->
                                        </tr>
                                    @endforeach
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total Nilai:</strong></td>
                                    <td id="totalNilai" class="text-left">{{ $totalNilai }}</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong>Total Skor (4 x Jumlah
                                            Indikator):</strong></td>
                                    <td id="totalSkor" class="text-left">0</td>
                                </tr>
                                <tr>
                                    <td colspan="5" class="text-right"><strong> Ketercapaian :</strong>
                                    </td>
                                    <td id="ketercapaian" class="text-left">0</td>
                                </tr>
                            </tfoot>
                            @endforeach
                            </tbody>
                        </table>

                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                        <style>
                            /* CSS untuk input yang ada di kolom indikator */
                            .editable input {
                                text-align: center;
                                /* Teks input center */
                            }

                            /* CSS untuk input yang ada di kolom keterangan */
                            .editable-keterangan input {
                                text-align: left;
                                /* Teks input keterangan tidak terpusat */
                            }
                        </style>
<script>
    $(document).ready(function() {
        // Fungsi untuk menghitung total nilai dan total skor
        function updateTotal() {
            let total = 0;
            let totalIndikator = 0; // Inisialisasi jumlah indikator yang memiliki data

            // Menghitung total nilai dari setiap baris
            $('tbody tr').each(function() {
                let rowTotal = 0;
                let validRow = false; // Flag untuk menandakan apakah ada nilai valid di baris ini

                // Untuk setiap kolom di baris ini
                $(this).find('.editable').each(function() {
                    let currentValue = $(this).text().trim();

                    if ($.isNumeric(currentValue) && currentValue !== "") {
                        rowTotal += parseFloat(currentValue); // Menjumlahkan nilai dalam satu baris
                        validRow = true; // Tandakan bahwa baris ini memiliki nilai valid
                    }
                });

                // Jika baris ini memiliki nilai valid, tambahkan total nilai baris ke total keseluruhan
                if (validRow) {
                    totalIndikator++; // Menambahkan jumlah indikator valid
                    total += rowTotal; // Menambahkan nilai baris ke total nilai
                }
            });

            // Menampilkan total nilai di tabel
            $('#totalNilai').text(total);

            // Menampilkan jumlah indikator dengan data
            console.log("Jumlah indikator dengan data: " + totalIndikator);

            // Menghitung total skor maksimal (4 dikali jumlah indikator yang memiliki data)
            let totalSkor = totalIndikator * 4;
            $('#totalSkor').text(totalSkor);

            // Menghitung ketercapaian dalam persen
            let ketercapaian = (total / (totalIndikator * 4)) * 100;
            $('#ketercapaian').text(ketercapaian.toFixed(2) + '%');
        }

        // Untuk update nilai penilaian
        $(document).on('click', '.editable', function() {
            let cell = $(this);
            let indikatorId = cell.closest('tr').data('id'); // Ambil ID indikator
            let kode = cell.data('kode'); // Ambil kode
            let currentValue = cell.text().trim();

            if (cell.find('input').length > 0) return; // Jika input sudah ada, abaikan

            let inputField = $("<input>", {
                type: "number",
                class: "form-control",
                value: currentValue,
                min: 0,
                max: 4
            });

            cell.html(inputField);
            inputField.focus();

            // Fungsi ketika input kehilangan fokus (blur)
            inputField.blur(function() {
                let newValue = $(this).val();
                let finalValue = kode + newValue; // Gabungkan kode dengan nilai input

                // Jika nilai tidak berubah, kembalikan ke nilai awal
                if (newValue === currentValue) {
                    cell.text(currentValue);
                    return;
                }

                // Kirim data ke server
                $.ajax({
                    url: "/program/supervisi/supervisi-perangkat-guru/" + indikatorId,
                    type: "PUT",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        indikator_id: indikatorId,
                        nilai: finalValue
                    },
                    success: function(response) {
                        console.log("✅ Respons dari server:", response);
                        alert(response.message);
                        cell.text(newValue); // Update tampilan dengan nilai baru
                        updateTotal(); // Update total setelah perubahan
                    },
                    error: function(xhr) {
                        console.error("❌ Error dari server:", xhr.responseText);
                        alert("Terjadi kesalahan saat memperbarui data.");
                        cell.text(currentValue); // Kembalikan nilai jika gagal
                    }
                });
            });

            // Fungsi untuk menangani tombol Enter dan Escape
            inputField.on('keydown', function(e) {
                // Jika tombol Enter ditekan
                if (e.key === 'Enter') {
                    let newValue = $(this).val();
                    let finalValue = kode + newValue;

                    // Jika nilai berubah, kirim ke server
                    if (newValue !== currentValue) {
                        $.ajax({
                            url: "/program/supervisi/supervisi-perangkat-guru/" + indikatorId,
                            type: "PUT",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                indikator_id: indikatorId,
                                nilai: finalValue
                            },
                            success: function(response) {
                                console.log("✅ Respons dari server:", response);
                                // alert(response.message);
                                cell.text(newValue); // Update tampilan dengan nilai baru
                                updateTotal(); // Update total setelah perubahan
                            },
                            error: function(xhr) {
                                console.error("❌ Error dari server:", xhr.responseText);
                                alert("Terjadi kesalahan saat memperbarui data.");
                                cell.text(currentValue); // Kembalikan nilai jika gagal
                            }
                        });
                    } else {
                        cell.text(currentValue); // Jika tidak ada perubahan, kembalikan nilai lama
                    }
                }

                // Jika tombol Escape ditekan
                if (e.key === 'Escape') {
                    cell.text(currentValue); // Kembalikan nilai lama jika Escape ditekan
                }
            });
        });

        // Untuk update keterangan
        $(document).on('click', '.editable-keterangan', function() {
            let cell = $(this);
            let indikatorId = cell.closest('tr').data('id'); // Ambil ID indikator
            let currentValue = cell.text().trim();

            if (cell.find('input').length > 0) return; // Jika input sudah ada, abaikan

            // Buat input field untuk keterangan
            let inputField = $("<input>", {
                type: "text",
                class: "form-control",
                value: currentValue
            });

            cell.html(inputField);
            inputField.focus();

            // Ketika input kehilangan fokus (blur)
            inputField.blur(function() {
                let newValue = $(this).val();

                // Jika keterangan tidak berubah, kembali ke nilai semula
                if (newValue === currentValue) {
                    cell.text(currentValue);
                    return;
                }

                console.log("🔍 Data yang akan dikirim:", {
                    indikator_id: indikatorId,
                    keterangan: newValue
                });

                $.ajax({
                    url: "/program/supervisi/supervisi-perangkat-guru/" + indikatorId, // URL yang sama untuk update data
                    type: "PUT", // Gunakan metode PUT
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        indikator_id: indikatorId, // Kirim indikator_id
                        keterangan: newValue // Kirim keterangan baru
                    },
                    success: function(response) {
                        console.log("✅ Respons dari server:", response);
                        // alert(response.message); // Tampilkan pesan sukses
                        cell.text(newValue); // Update tampilan dengan nilai baru
                    },
                    error: function(xhr) {
                        console.error("❌ Error dari server:", xhr.responseText);
                        alert("Terjadi kesalahan saat memperbarui data."); // Tampilkan pesan error
                        cell.text(currentValue); // Kembalikan nilai jika gagal
                    }
                });
            });

            // Fungsi untuk menangani tombol Enter dan Escape pada input keterangan
            inputField.on('keydown', function(e) {
                // Jika tombol Enter ditekan
                if (e.key === 'Enter') {
                    let newValue = $(this).val();

                    if (newValue !== currentValue) {
                        $.ajax({
                            url: "/program/supervisi/supervisi-perangkat-guru/" + indikatorId,
                            type: "PUT",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                indikator_id: indikatorId,
                                keterangan: newValue
                            },
                            success: function(response) {
                                console.log("✅ Respons dari server:", response);
                                alert(response.message);
                                cell.text(newValue); // Update tampilan dengan nilai baru
                            },
                            error: function(xhr) {
                                console.error("❌ Error dari server:", xhr.responseText);
                                alert("Terjadi kesalahan saat memperbarui data.");
                                cell.text(currentValue); // Kembalikan nilai jika gagal
                            }
                        });
                    } else {
                        cell.text(currentValue); // Kembalikan ke nilai awal jika tidak ada perubahan
                    }
                }

                // Jika tombol Escape ditekan
                if (e.key === 'Escape') {
                    cell.text(currentValue); // Kembalikan nilai lama jika Escape ditekan
                }
            });
        });

        // Jalankan fungsi updateTotal() saat halaman dimuat
        updateTotal();
    });
</script>
<div class='card my-4'>
    <div class='card-header bg-primary'>
        <h3 class='card-title'>Saran</h3>
    </div>
    <div class='card-body'>
       <div class='form-group'>
       <label for='catatan'>Catatan</label>
       <input type='text' class='editor form-control' id='catatan' name='catatan' placeholder='Catatan' required>
       </div>
       <script>
       function initTinyMCE(selector = '.editor') {
           if (typeof tinymce !== 'undefined') {
               tinymce.remove(); // Hapus instance lama untuk mencegah duplikasi
               console.log(`Menginisialisasi TinyMCE pada $selector...`);

               tinymce.init({
                   selector: selector,
                   plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help',
                   menubar: 'file edit view insert format tools table help',
                   toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat fullscreen code',
                   height: 400,
                   setup: function(editor) {
                       editor.on('init', function() {
                           console.log(`TinyMCE siap digunakan pada $selector!`);
                       });
                   }
               });
           } else {
               console.error('TinyMCE tidak ditemukan! Pastikan file tinymce.min.js sudah dimuat.');
           }
       }

       document.addEventListener('DOMContentLoaded', function() {
           initTinyMCE(); // Inisialisasi editor untuk pertama kali

           // Pastikan semua form menyimpan data dari TinyMCE sebelum submit
           document.querySelectorAll('form').forEach(form => {
               form.addEventListener('submit', function() {
                   tinymce.triggerSave();
               });
           });
       });

       // Jika ingin re-inisialisasi (misal setelah AJAX load atau modal dibuka)
       function reinitTinyMCE() {
           initTinyMCE();
       }
       </script>
    </div>
</div>




                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
