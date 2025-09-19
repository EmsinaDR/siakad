@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    // dd($Siswas);
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
<button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#PilihData'><i class='fa fa-plus'></i> Mulai Buat</button>
                   </div>
                   <div class='col-xl-10'>
<!-- Dropdown pilih background -->
<div class="form-group">
    <label for="bg_select">Pilih Background Sertifikat</label>
    <select id="bg_select" class="form-control">
        <option value="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_p1e81-BBzn1wTy-9h2AkxSmnW9rRjEBgnKlCpA8dNDf0F4zwNFZDcVDYfCsqsmO-XeJT2Nsn8bZnxAK0tIKPRPldz25ObXWZY8C5FcZV30LagUY62GbHyQJ9F9OH4L7wVn7e9sovHcsr/s400/Frame+Sertifikat+Elegan+9+Free.jpg">Piagam Penghargaan</option>
        <option value="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_p1e81-BBzn1wTy-9h2AkxSmnW9rRjEBgnKlCpA8dNDf0F4zwNFZDcVDYfCsqsmO-XeJT2Nsn8bZnxAK0tIKPRPldz25ObXWZY8C5FcZV30LagUY62GbHyQJ9F9OH4L7wVn7e9sovHcsr/s400/Frame+Sertifikat+Elegan+9+Free.jpg">Sertifikat Pelatihan</option>
        <option value="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_p1e81-BBzn1wTy-9h2AkxSmnW9rRjEBgnKlCpA8dNDf0F4zwNFZDcVDYfCsqsmO-XeJT2Nsn8bZnxAK0tIKPRPldz25ObXWZY8C5FcZV30LagUY62GbHyQJ9F9OH4L7wVn7e9sovHcsr/s400/Frame+Sertifikat+Elegan+9+Free.jpg">Lomba Tingkat Nasional</option>
    </select>
</div>

<!-- TinyMCE Editor -->
<textarea id="editor_konten_sertifikat" class="editor">Piagam Penghargaan diberikan kepada...</textarea>

<!-- Preview Sertifikat -->
<div id="preview_konten" style="width: 29.7cm; height: 21cm; border: 1px solid #ccc; padding: 2cm; background-size: cover; background-position: center; margin-top: 2rem;">
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script&family=Montserrat&family=Poppins&display=swap" rel="stylesheet">


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // TinyMCE Init
        tinymce.init({
            selector: 'textarea.editor',
            height: 300,
            menubar: 'file edit view insert format tools table help',
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                    toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table | removeformat fullscreen code | pagebreak',
            font_family_formats: 'Arial=arial,helvetica,sans-serif; Georgia=georgia,palatino; Times New Roman=times new roman,times;',
            fontsize_formats: '12px 14px 16px 18px 24px 32px 48px',
            content_style: 'body { font-family:Arial; font-size:16px; }',
            font_family_formats: `
        Arial=arial,helvetica,sans-serif;
        Times New Roman=times new roman,times;
        Georgia=georgia,palatino;
        Comic Sans MS=comic sans ms,sans-serif;
        Courier New=courier new,courier;
        Poppins='Poppins', sans-serif;
        Montserrat='Montserrat', sans-serif;
        Dancing Script='Dancing Script', cursive;
    `,

            setup: function (editor) {
                // Update preview saat isi diubah
                editor.on('input change keyup paste', function () {
                    updatePreview();
                });
            }
        });

        // Update preview background saat dropdown berubah
        document.getElementById('bg_select').addEventListener('change', function () {
            updatePreview();
        });

        // Fungsi update preview isi dan background
        function updatePreview() {
            let isi = tinymce.get('editor_konten_sertifikat').getContent();
            let bg = document.getElementById('bg_select').value;
            let previewDiv = document.getElementById('preview_konten');

            previewDiv.innerHTML = isi;
            previewDiv.style.backgroundImage = `url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_p1e81-BBzn1wTy-9h2AkxSmnW9rRjEBgnKlCpA8dNDf0F4zwNFZDcVDYfCsqsmO-XeJT2Nsn8bZnxAK0tIKPRPldz25ObXWZY8C5FcZV30LagUY62GbHyQJ9F9OH4L7wVn7e9sovHcsr/s400/Frame+Sertifikat+Elegan+9+Free.jpg')`; // ganti sesuai path folder kamu
            // previewDiv.style.backgroundImage = `url('/path/to/backgrounds/${bg}')`; // ganti sesuai path folder kamu
        }

        // Jalankan update pertama kali
        setTimeout(updatePreview, 1000);
    });
</script>

                   </div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
                </div>
               </div>
               {{-- blade-formatter-enable --}}
            @php
                $data_nama = 'Dany Rosepta';
                $data_peran = 'Pemateri';
                $data_nama_seminar = 'Seminar Penggunaan Teknologi Dalam Pengembangan Pembelajaran';
                $data_tanggal = Carbon::now()->translatedFormat('l, d F Y');
                $data_tempat = 'Brebes';
                $data_nomor_sertifikat = '29/02/SPT/2025';
                $data_nama_ketua_panitia = 'Farid Atallah';
                $data_nip_ketua_panitia = '2802091989';
                $data_nama_kepala_sekolah = 'Aurora Ze';
                $data_nip_kepala_sekolah = '28122023291989';
            @endphp

            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div
                            style="width: 1000px;
                             background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    color: #000;
                                background-image: url('{{ asset('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg_p1e81-BBzn1wTy-9h2AkxSmnW9rRjEBgnKlCpA8dNDf0F4zwNFZDcVDYfCsqsmO-XeJT2Nsn8bZnxAK0tIKPRPldz25ObXWZY8C5FcZV30LagUY62GbHyQJ9F9OH4L7wVn7e9sovHcsr/s400/Frame+Sertifikat+Elegan+9+Free.jpg') }}');

                            padding: 40px;
                            border: 10px solid #000; text-align: center; font-family: 'Georgia', serif;">
                            <div style="border: 5px solid #000; padding: 30px;">

                                <!-- Logo kiri dan kanan -->
                                <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
                                    <img src="{{ asset('https://upload.wikimedia.org/wikipedia/commons/thumb/9/9c/Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg/2048px-Logo_of_Ministry_of_Education_and_Culture_of_Republic_of_Indonesia.svg.png') }}"
                                        alt="Logo Kiri" style="height: 100px;">
                                    <img src="{{ asset('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReZkNwpParhEEDbou90V62EgPnwC4M9iJQ8g&s') }}"
                                        alt="Logo Kanan" style="height: 100px;">
                                </div>

                                <!-- Judul Sertifikat -->
                                <h1 style="font-size: 40px; margin-bottom: 10px;"><b id="Bentuk_display"
                                        class="text-info">Belum dipilih</b></h1>
                                <p style="font-size: 18px; margin-bottom: 20px;">Nomor: {{ $data_nomor_sertifikat }}</p>

                                <!-- Isi Sertifikat -->
                                <p style="font-size: 20px;">Diberikan kepada:</p>
                                <h2 style="font-size: 28px; margin: 20px 0; text-transform: uppercase;">
                                    <div id="siswa_display" class="mt-2 text-info"></div>
                                </h2>
                                <p style="font-size: 20px;">Sebagai <b id="Peran_display"
                                        class="text-info"></b></strong> dalam kegiatan
                                </p>
                                <h3 style="font-size: 24px; margin: 15px 0;">"<b id="nama_kegiatan_display"
                                        class="mt-2 text-info"></b>"</h3>
                                <p style="font-size: 18px;">
                                    yang diselenggarakan pada tanggal {{ $data_tanggal }} di {{ $data_tempat }}.
                                </p>

                                <!-- Tanda tangan -->
                                <div
                                    style="margin-top: 50px; display: flex; justify-content: space-between; padding: 0 40px;">
                                    <div style="text-align: center;">
                                        <p>Ketua Panitia</p><br><br><br>
                                        <u>{{ $data_nama_ketua_panitia }}</u><br>
                                        NIP: {{ $data_nip_ketua_panitia }}
                                    </div>
                                    <div style="text-align: center;">
                                        <p>Kepala Sekolah</p><br><br><br>
                                        <u>{{ $data_nama_kepala_sekolah }}</u><br>
                                        NIP: {{ $data_nip_kepala_sekolah }}
                                    </div>
                                </div>

                                <!-- Logo bawah (jika diperlukan) -->
                                <div style="margin-top: 40px; display: flex; justify-content: space-between;">
                                    <img src="{{ asset('logo_kiri.png') }}" alt="Logo Kiri" style="height: 60px;">
                                    <img src="{{ asset('logo_kanan.png') }}" alt="Logo Kanan" style="height: 60px;">
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='PilihData' tabindex='-1' aria-labelledby='LabelPilihData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPilihData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='PilihData-form' action='{{ route('template-sertifikat.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php
                        $Peran = [
                            'Peserta',
                            'Panitia',
                            'Juri',
                            'Pemateri',
                            'Moderator',
                            'Juara I',
                            'Juara II',
                            'Juara III',
                            'Peringkat I',
                            'Peringkat II',
                            'Peringkat III',
                        ];
                        $Bentuk = ['Sertifikat', 'Piagam Penghargaan'];
                    @endphp
                    <div class='form-group'>
                        <label for='bentuk'>Bentuk</label>
                        <select name='bentuk' id='data_bentuk' class='select2 form-control' required>
                            <option value=''>--- Pilih Bentuk ---</option>
                            @foreach ($Bentuk as $nBentuk)
                                <option value='{{ $nBentuk }}'>{{ $nBentuk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='color_bentuk'>Warna</label>
                        <input type='color' class='form-control' id='color_bentuk' name='color_bentuk'
                            placeholder='placeholder' required>
                    </div>
                    <div class="form-group">
                        <label for="font_family">Jenis Font</label>
                        <select id="font_family" class="form-control">
                            <option value="Arial">Arial</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Courier New">Courier New</option>
                            <option value="Comic Sans MS">Comic Sans MS</option>
                            <option value="Trebuchet MS">Trebuchet MS</option>
                            <option value="Impact">Impact</option>
                            <option value="'Segoe UI'">Segoe UI</option>
                            <option value="'Lucida Console'">Lucida Console</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="font_style">Gaya Font</label>
                        <select id="font_style" class="form-control">
                            <option value="">-- Pilih Gaya Font --</option>
                            <option value="normal">Normal</option>
                            <option value="italic">Italic</option>
                            <option value="bold">Bold</option>
                            <option value="underline">Underline</option>
                            <option value="bold italic">Bold + Italic</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="font_size">Ukuran Font</label>
                        <select id="font_size" class="form-control">
                            <option value="12px">12 px (Kecil)</option>
                            <option value="16px" selected>16 px (Normal)</option>
                            <option value="20px">20 px (Sedang)</option>
                            <option value="24px">24 px (Besar)</option>
                            <option value="32px">32 px (Judul)</option>
                            <option value="48px">48 px (Sangat Besar)</option>
                        </select>
                    </div>




                    <div class='form-group'>
                        <label for='nama_kegiatan'>Nama Kegiatan</label>
                        <input type='text' class='form-control' id='nama_kegiatan' name='nama_kegiatan'
                            placeholder='Nama Kegiatan' required>
                    </div>
                    <div class='form-group'>
                        <label for='tempat_pelaksanaan'>Tempat Pelaksanaan</label>
                        <input type='text' class='form-control' id='tempat_pelaksanaan' name='tempat_pelaksanaan'
                            placeholder='Tempat Pelaksanaan' required>
                    </div>
                    <div class='form-group'>
                        <label for='tanggal_pelaksanaan'>Tanggal</label>
                        <input type='date' class='form-control' id='tanggal_pelaksanaan'
                            name='tanggal_pelaksanaan' placeholder='Tanggal Pelaksanaan' required>
                    </div>
                    <div class='form-group'>
                        <label for='Peran'>Peran Sebagai</label>
                        <select name='Peran' id='Peran' data-placeholder='Pilih Data Peran Sebagai'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Peran Sebagai ---</option>
                            @foreach ($Peran as $newPeran)
                                <option value='{{ $newPeran }}'>{{ $newPeran }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='data_siswa'>Data Siswa</label>
                        <select name='data_siswa' id='data_siswa' data-placeholder='Pilih Data Data Siswa'
                            class='select2 form-control' required>
                            <option value=''>--- Pilih Data Siswa ---</option>
                            @foreach ($Siswas as $newSiswas)
                                <option value='{{ $newSiswas->id }}'>{{ $newSiswas->nama_siswa }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tampilkan hasil input -->

                    <div id="nama_kegiatan_display" class="mt-2 text-info"></div>
                    <div id="Peran_display" class="mt-2 text-info"></div>
                    <div id="siswa_display" class="mt-2 text-info"></div>

                    {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                           </div>
                           {{-- blade-formatter-enable --}}

                </form>
            </div>

        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins&family=Dancing+Script&display=swap" rel="stylesheet">

<script>
    $(document).ready(function() {
        // Saat input nama_kegiatan berubah
        $('#nama_kegiatan').on('input', function() {
            let value = $(this).val();
            $('#nama_kegiatan_display').text(value);
        });

        // Saat select Peran berubah
        $('#Peran').on('change', function() {
            let Peran = $(this).val();
            $('#Peran_display').text(Peran);
        });

        // Saat select siswa berubah
        $('#data_siswa').on('change', function() {
            let nama = $('#data_siswa option:selected').text();
            $('#siswa_display').text(nama);
        });

        // Event binding
        $('#data_bentuk').on('change', updateBentukDisplay);
        $('#color_bentuk').on('input', updateBentukDisplay);
        $('#font_style').on('change', updateBentukDisplay);
        $('#font_family').on('change', updateBentukDisplay);
        $('#font_size').on('change', updateBentukDisplay);


        // Fungsi utama
        function updateBentukDisplay() {
            let bentukText = $('#data_bentuk option:selected').text();
            let warna = $('#color_bentuk').val();
            let style = $('#font_style').val();
            let font = $('#font_family').val();
            let ukuran = $('#font_size').val();

            // Set isi teks
            let $display = $('#Bentuk_display');
            $display.text(bentukText);

            // Siapkan style inline lengkap dengan !important di warna
            let cssStyle = `color: ${warna} !important; font-family: ${font}; font-size: ${ukuran};`;


            // Tambah font-weight jika bold
            if (style.includes('bold')) {
                cssStyle += ' font-weight: bold;';
            } else {
                cssStyle += ' font-weight: normal;';
            }

            // Tambah font-style jika italic
            if (style.includes('italic')) {
                cssStyle += ' font-style: italic;';
            } else {
                cssStyle += ' font-style: normal;';
            }

            // Tambah underline jika ada
            if (style.includes('underline')) {
                cssStyle += ' text-decoration: underline;';
            } else {
                cssStyle += ' text-decoration: none;';
            }

            // Apply seluruh style ke elemen display
            $display.attr('style', cssStyle);
        }

    });
</script>
