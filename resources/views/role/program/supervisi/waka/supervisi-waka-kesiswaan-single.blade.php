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
                       {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button> --}}
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
                        <h3 class="text-center"><b>INSTRUMEN PENILAIAN WAKA KURIKULUM</b></h3>
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
                                        <td class='text-left'> : ..................</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>NIP/NUPTK</td>
                                        <td class='text-left'> :..................</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-xl-6 mt-1">
                                <table id='example1' width='100%' class='table table-bordered'>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Sertifikasi</td>
                                        <td class='text-left'> : Tahun .................. </td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Tahun Pelajaran</td>
                                        <td class='text-left'> : {{ $Tapels->tapel }}/ {{ $Tapels->tapel + 1 }}</td>
                                    </tr>
                                    <tr class='text-center align-middle'>
                                        <td width='35%' class='text-left'>Semester</td>
                                        <td class='text-left'> : {{ $Tapels->semester }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        {{-- blade-formatter-disable --}}
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Indikator</th>
                                    <th class="text-center">Ketersediaan</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Instrumens as $sub_kategori => $items)
                                    <tr class="table-info">
                                        <th colspan="5" class="text-left">
                                            {{ $sub_kategori ?: 'Tanpa Sub Kategori' }}
                                        </th>
                                    </tr>

                                    @foreach ($items as $data)
                                        <tr class="text-center" data-id="{{ $data->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $data->indikator }}</td>
                                            <td class="text-center" width='10%' data-field="ketersediaan"
                                                onclick="editCell(event, {{ $data->id }}, 'ketersediaan')">
                                                {!! $data->ketersediaan === 'Y'
                                                    ? '<i class="fas fa-check text-success"></i>'
                                                    : '<i class="fas fa-times text-danger"></i>' !!}
                                            </td>
                                            <td class="text-center" width='10%' data-field="nilai"
                                                onclick="editCell(event, {{ $data->id }}, 'nilai')">
                                                {{ $data->nilai }}
                                            </td>
                                            <td class="text-justify" width='35%' data-field="keterangan"
                                                onclick="editCell(event, {{ $data->id }}, 'keterangan')">
                                                {{ $data->keterangan }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            <tfoot>
                                <tr>
                                    <th colspan='3' class='text-right'>Jumlah Skor</th>
                                    <th id="totalSkor">0</th>
                                </tr>
                                <tr>
                                    <th colspan='3' class='text-right'>Skor Maksimum</th>
                                    <th id="maxSkor">0</th>
                                </tr>
                                <tr>
                                    <th colspan='3' class='text-right'>Persentase Ketercapaian</th>
                                    <th id="persenketercapaian">0</th>
                                </tr>
                            </tfoot>


                            </tbody>
                        </table>

                        <div class="row my-4">
                            <div class="col-xl-8  d-flex justify-content-end">

                            </div>
                            <div class="col-xl-4 d-flex justify-content-end">
                                <div class="card col-6">
                                    <table id='example1' width='100%' class='table table-bordered table-hover my-2'>
                                        <thead>
                                            <tr class='table-primary text-center align-middle'>
                                                <th>Interval</th>
                                                <th>Predikat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class='text-center'>
                                                    < 55%</td>
                                                <td class='text-center'> Kurang</td>
                                            </tr>
                                            <tr>
                                                <td class='text-center'> 55 - 70 %</td>
                                                <td class='text-center'> Cukup</td>
                                            </tr>
                                            <tr>
                                                <td class='text-center'> 71 - 85 %</td>
                                                <td class='text-center'> Baik</td>
                                            </tr>
                                            <tr>
                                                <td class='text-center'> 86 - 100 %</td>
                                                <td class='text-center'> Baik Sekali</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class='table-primary text-center align-middle'>
                                                <th>Interval</th>
                                                <th>Predikat</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card col-6">
                                    <div class='card-header bg-success d-flex justify-content-center my-2'>
                                        <h3 class='card-title'>Nilai Akhir</h3>
                                    </div>
                                    <div class='card-body'>
                                        <h1 class="d-flex justify-content-center" style="font-size:100px"><b>A</b>
                                        </h1>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <script>
                            function editCell(event, id, field) {
                                var currentValue = $(event.target).text().trim();

                                if (field === 'nilai') {
                                    currentValue = (currentValue >= 1 && currentValue <= 4) ? currentValue : '1'; // Default 1 jika tidak valid
                                }

                                var inputField = $('<input>', {
                                    type: 'text',
                                    value: currentValue,
                                    class: 'form-control',
                                    'data-id': id,
                                    'data-field': field
                                });

                                $(event.target).html(inputField);
                                inputField.focus();

                                inputField.on('blur', function() {
                                    saveChange(event, inputField, id, field);
                                });

                                inputField.on('keydown', function(e) {
                                    if (field === 'ketersediaan') {
                                        inputField.val(inputField.val().toUpperCase());
                                        if (!['Y', 'N'].includes(e.key.toUpperCase()) && e.key !== 'Backspace') {
                                            e.preventDefault();
                                        }
                                    }

                                    if (field === 'nilai') {
                                        let newValue = parseInt(inputField.val());
                                        if (isNaN(newValue) || newValue < 1 || newValue > 4) {
                                            inputField.val('1');
                                        }
                                    }

                                    if (e.key === 'Enter') {
                                        saveChange(event, inputField, id, field);
                                    }

                                    if (e.key === 'Escape') {
                                        cancelEdit(event, inputField, currentValue, field);
                                    }
                                });

                                if (field === 'ketersediaan' && currentValue === 'Y') {
                                    $(event.target).css({
                                        'font-size': '18px',
                                        'text-align': 'center'
                                    });
                                }
                            }

                            function saveChange(event, inputField, id, field) {
                                var newValue = inputField.val().trim();

                                if (field === 'ketersediaan') {
                                    newValue = newValue.toUpperCase();
                                }

                                if (field === 'nilai') {
                                    newValue = Math.max(1, Math.min(4, parseInt(newValue) || 1));
                                }

                                $.ajax({
                                    url: `/program/supervisi/supervisi-waka-kurikulum/${id}`,
                                    method: 'PUT',
                                    data: {
                                        _token: $('meta[name="csrf-token"]').attr('content'),
                                        field: field,
                                        value: newValue
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            $(event.target).text(newValue);
                                            updateCalculations(); // Update perhitungan total

                                            if (field === 'ketersediaan' && newValue === 'Y') {
                                                $(event.target).css({
                                                    'font-size': '18px',
                                                    'text-align': 'center'
                                                });
                                            } else {
                                                $(event.target).css({
                                                    'font-size': '',
                                                    'text-align': ''
                                                });
                                            }
                                        } else {
                                            alert('Error: ' + response.message);
                                        }
                                    },
                                    error: function() {
                                        alert('An error occurred while updating the data.');
                                    }
                                });
                            }

                            function cancelEdit(event, inputField, currentValue, field) {
                                $(event.target).text(currentValue);

                                if (field === 'ketersediaan' && currentValue === 'Y') {
                                    $(event.target).css({
                                        'font-size': '18px',
                                        'text-align': 'center'
                                    });
                                }
                            }

                            /// **🔹 Fungsi Perhitungan Otomatis**
                            function updateCalculations() {
                                let totalScore = 0;
                                let rowCount = 0;

                                // Loop untuk menghitung total nilai
                                $('td[data-field="nilai"]').each(function() {
                                    let value = parseInt($(this).text().trim()) || 0;
                                    totalScore += value;
                                    rowCount++;
                                });

                                let maxScore = rowCount * 4;
                                let percentAchievement = (maxScore > 0) ? ((totalScore / maxScore) * 100).toFixed(2) : 0;

                                // Update skor total dan persentase
                                $('#totalSkor').text(totalScore);
                                $('#maxSkor').text(maxScore);
                                $('#persenketercapaian').text(percentAchievement + ' %');

                                // Menentukan predikat berdasarkan persentase capaian
                                let predikat = '';
                                if (percentAchievement < 55) {
                                    predikat = 'K';
                                } else if (percentAchievement >= 55 && percentAchievement <= 70) {
                                    predikat = 'C';
                                } else if (percentAchievement > 70 && percentAchievement <= 85) {
                                    predikat = 'B';
                                } else if (percentAchievement > 85) {
                                    predikat = 'BS';
                                }

                                // Update elemen predikat
                                $('.card-body h1').html('<b>' + predikat + '</b>');
                            }

                            // **🔹 Panggil fungsi saat halaman pertama kali dimuat**
                            $(document).ready(function() {
                                updateCalculations();
                            });
                        </script>


                        <div class='card my-4'>
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Saran</h3>
                            </div>
                            <div class='card-body'>
                                <div class='form-group'>
                                    <label for='catatan'>Catatan</label>
                                    <input type='text' class='editor form-control' id='catatan' name='catatan'
                                        placeholder='Catatan' required>
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
