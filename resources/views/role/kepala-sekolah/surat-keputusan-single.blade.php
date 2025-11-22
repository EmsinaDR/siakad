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
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='CekDataRapat()'> <i class='fa fa-plus'></i> Cek Data Rapat</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
                    {{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='updateurl' action='{{ route('surat-keputusan.update', $data->id) }}' method='POST'>
                            @csrf
                            @method('PATCH')
                            {{-- blade-formatter-disable --}}
                                <div class="col-6 form-group">
                                    <label class="block text-gray-700">Nomor SK</label>
                                    <input id='nomor_sk' type="text" name="nomor_sk" value="{{ old('nomor_sk', $data->nomor_sk ?? '') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200" readonly>
                                </div>
                            <div class="row">
                                <div class="col-6 form-group">
                                    <label class="block text-gray-700">Nama SK</label>
                                    <input type="text" name="nama_sk" value="{{ old('nama_sk', $data->nama_sk ?? '') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                </div>
                                <div class="col-6 form-group">
                                    <label class="block text-gray-700">Tanggal SK</label>
                                    <input type="date" name="tanggal_sk" value="{{ old('tanggal_sk', $data->tanggal_sk ?? '') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Pejabat Penerbit</label>
                                <input type="text" name="pejabat_penerbit" value="{{ old('pejabat_penerbit', $data->pejabat_penerbit ?? '') }}" class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Perihal</label>
                                <textarea name="perihal" class="editor form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">{{ old('perihal', $data->perihal ?? '') }}</textarea>
                            </div>

                            {{-- <div class="form-group">
                                <label class="block text-gray-700">Content System</label>
                                <textarea id="content_system" name="content_system" class="editor form-control p-2 border border-gray-300  rounded-lg">{{ old('content_system', $data->content_system ?? '') }}</textarea>
                            </div> --}}

                           <div class="form-group">
                                <label class="block text-gray-700">Content Sekolah</label>
                                <textarea id="content_sekolah" name="content_sekolah" class="editor form-control p-2 border border-gray-300 rounded-lg">
                                    {{ old('content_sekolah', $data->content_sekolah ?? '') }}
                                </textarea>
                            </div>





                            <div class="form-group">
                                <label class="block text-gray-700">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control p-2 border border-gray-300 rounded-lg focus:ring  focus:ring-blue-200">{{ old('deskripsi', $data->deskripsi ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="block text-gray-700">Unggah File SK</label>
                                <input type="file" name="file"
                                    class="form-control p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
                                @if (isset($data) && $data->file_path)
                                    <p class="text-sm mt-2">File saat ini: <a href="{{ asset('storage/' . $data->file_path) }}" class="text-blue-600 underline" target="_blank">{{ $data->file_name }}</a>
                                    </p>
                                @endif
                            </div>
                            {{-- blade-formatter-enable --}}

                            <button id='kirim' type='submit'
                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                Kirim</button>
                        </form>

                    </div>
                </div>
            </div>


            <!-- Tambahkan Script TinyMCE -->
            {{-- <script>
                moment.locale('id');
            </script> --}}

            {{-- <script>
                document.addEventListener("DOMContentLoaded", function() {
                    moment.updateLocale('id', moment.localeData('id')); // Paksa update
                    moment.updateLocale('id', {
                        months: "Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember"
                            .split("_"),
                        monthsShort: "Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agt_Sep_Okt_Nov_Des".split("_"),
                        weekdays: "Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu".split("_"),
                        weekdaysShort: "Min_Sen_Sel_Rab_Kam_Jum_Sab".split("_"),
                        weekdaysMin: "Mg_Sn_Sl_Rb_Km_Jm_Sb".split("_")
                    });


                    console.log("Locale setelah update:", moment.locale()); // Cek hasilnya

                    let rapatList = @json($DataRapats);

                    let suggestions = rapatList.map(item => {
                        let tanggalFormatted = moment(item.tanggal_pelaksanaan)
                            .locale('id')
                            .format('dddd, DD MMMM YYYY'); // Mungkin ini masih pakai locale sebelumnya

                        console.log(`Sebelum format: ${item.tanggal_pelaksanaan}`);
                        console.log(`Sesudah format: ${tanggalFormatted}`);

                        return {
                            value: `${item.nama_rapat} - ${tanggalFormatted}`,
                            text: `${item.nama_rapat} - ${tanggalFormatted}`
                        };
                    });


                    tinymce.init({
                        selector: "#content_sekolah",
                        selector: '#content_sekolah', // Target textarea dengan class .editor
                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table',
                        menubar: 'file edit view insert format tools table help', // Tambahkan "view" agar fullscreen muncul
                        toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat fullscreen code',
                        // contextmenu: 'table delete-table', // Klik kanan di tabel bisa menampilkan opsi hapus tabel
                        // quickbars_insert_toolbar: 'inserttable'
                        table_sizing_mode: 'relative',
                        table_grid: true,
                        setup: function(editor) {
                            editor.ui.registry.addAutocompleter("rapatAutocompleter", {
                                trigger: "#",
                                minChars: 1,
                                fetch: function(pattern) {
                                    let filtered = suggestions.filter(item =>
                                        item.text.toLowerCase().includes(pattern.toLowerCase())
                                    );

                                    return new Promise((resolve) => {
                                        resolve(filtered);
                                    });
                                },
                                onAction: function(autocompleteApi, rng, value) {
                                    editor.selection.setRng(rng);
                                    editor.insertContent(
                                        `<span style="font-size: 16px; font-weight: normal;">${value}</span>`
                                    );
                                    autocompleteApi.hide();
                                }
                            });
                        }
                    });
                });
            </script> --}}


            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    moment.updateLocale('id', moment.localeData('id')); // Paksa update
                    moment.updateLocale('id', {
                        months: "Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember"
                            .split("_"),
                        monthsShort: "Jan_Feb_Mar_Apr_Mei_Jun_Jul_Agt_Sep_Okt_Nov_Des".split("_"),
                        weekdays: "Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu".split("_"),
                        weekdaysShort: "Min_Sen_Sel_Rab_Kam_Jum_Sab".split("_"),
                        weekdaysMin: "Mg_Sn_Sl_Rb_Km_Jm_Sb".split("_")
                    });

                    // Data Sugest Dari controller
                    let rapatList = @json($DataRapats);
                    let guruList = @json($DataGuru);
                    let ekstraList = @json($DataEkstras);
                    let kelasList = @json($Kelass);
                    let labsList = @json($DataLabs); // Menambahkan labsList
                    let mapelList = @json($DataMapels); // Menambahkan mapelList
                    let hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu',
                    'Minggu']; // Menambahkan hariList
                    let tugasList = ['Waka Kurikulum', 'Waka Kesiswaan', 'Waka Sarpras', 'Waka Humas', 'Ka. TU',
                        'Bendahara Komite', ' Bendahara BOS', 'Bendahara Bantuan', 'Pembina Osiswa',
                        'Koordinator Ekstra', 'Koordinator Keagamaan', 'Koordinator Keamanan dan Ketertiban',
                        'Koordinator Penjaminan Mutu Sekolah'
                    ]; // Menambahkan hariList

                    let rapatSuggestions = rapatList.map(item => {
                        let tanggalFormatted = moment(item.tanggal_pelaksanaan)
                            .locale('id')
                            .format('dddd, DD MMMM YYYY');
                        return {
                            value: `#${item.nama_rapat} - ${tanggalFormatted}`,
                            text: `🗓️ Rapat: ${item.nama_rapat} - ${tanggalFormatted}`
                        };
                    });

                    let guruSuggestions = guruList.map(item => {
                        return {
                            value: `#${item.nama_guru}`,
                            text: `👨‍🏫 Guru: ${item.nama_guru}`
                        };
                    });
                    let kodeSuggestions = guruList.map(item => {
                        return {
                            value: `#${item.kode_guru}`,
                            text: `👨‍🏫 Kode: ${item.kode_guru} - ${item.nama_guru}`
                        };
                    });

                    let ekstraSuggestions = ekstraList.map(item => {
                        return {
                            value: `#${item.ekstra}`,
                            text: `🎓 Ekstra: ${item.ekstra}`
                        };
                    });

                    // Membuat tabel dinamis untuk setiap ekstra yang dipilih (menggunakan foreach untuk menghasilkan baris tabel)
                    let tabelekstraSuggestions = [{
                        value: `#tabelekstra`,
                        text: `🎓 Tabel Ekstra`,
                        tableHTML: `
                            <h2 style='text-align:center'> Tabel Pembina Ekstra</h2>
                            <table border="1" style="width: 100%; border-collapse: collapse;" class='table table-responsive table-bordered table-hover'>
                                <tr style='text-align:center'>
                                    <th style='width:30px'>No</th>
                                    <th style='width:250px'>Ekstra</th>
                                    <th>Pembina</th>
                                    <th>Pelatih</th>
                                    <th>Jadwal</th>
                                </tr>
                                ${ekstraList.map(item => `
                                                    <tr style='text-align:left'>
                                                        <td style='width:100px;text-align:center'>${item.id}</td>
                                                        <td style='width:100px;text-align:left'>${item.ekstra}</td>
                                                        <td>${item.nama_guru ?? ''}</td>
                                                        <td>${item.pelatih ?? ''}</td>
                                                        <td>${item.jadwal ?? ''}</td>
                                                    </tr>
                                                `).join('')}
                            </table>`
                    }];

                    // Tabel Kelas
                    let tabelKelasSuggestions = [{
                        value: `#tabelkelas`,
                        text: `📚 Tabel Kelas`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel Wali Kelas</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th style='width:30px'>No</th>
                                        <th style='width:100px;text-align:center'>Kelas</th>
                                        <th>Wali Kelas</th>
                                    </tr>
                                    ${kelasList.map((item, index) => `
                                                    <tr style='width:100px;text-align:left'>
                                                        <td style='width:100px;text-align:center'>${index + 1}</td>  <!-- Indeks item ditambah 1 untuk nomor urut -->
                                                        <td style='width:100px;text-align:center'>${item.kelas}</td>
                                                        <td style='text-align:left'></td>  <!-- Anda bisa mengganti dengan data lainnya jika diperlukan-->
                                                    </tr>
                                                `).join('')}
                                </table>`
                    }];
                    // Tabel Pemetaan BK
                    let tabelBkSuggestions = [{
                        value: `#tabelbk`,
                        text: `📚 Tabel BK`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel BK</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th style='width:30px'>No</th>
                                        <th style='width:100px;text-align:center'>Kelas</th>
                                        <th>Guru</th>
                                    </tr>
                                    ${kelasList.map((item, index) => `
                                                    <tr style='width:100px;text-align:center'>
                                                        <td>${index + 1}</td>  <!-- Indeks item ditambah 1 untuk nomor urut -->
                                                        <td style='width:100px;text-align:center'>${item.kelas}</td>
                                                        <td style='text-align:LEFT'></td>  <!-- Anda bisa mengganti dengan data lainnya jika diperlukan-->
                                                    </tr>
                                                `).join('')}
                                </table>`
                    }];
                    // Tabel Kelas
                    let tabelLabsSuggestions = [{
                        value: `#tabellabs`,
                        text: `📚 Tabel Laboratorium`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel Laboratorium</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th style='width:30px'>No</th>
                                        <th>Nama Laboratorium</th>
                                        <th>Penanggung Jawab</th>
                                    </tr>
                                    ${labsList.map(item => `
                                                            <tr style='width:100px;text-align:center'>
                                                                <td style='width:30px'>${item.id}</td>
                                                                <td>${item.nama_laboratorium ?? ''}</td>
                                                                <td>${item.nama_guru ?? ''}</td>
                                                                <td></td>
                                                            </tr>
                                                        `).join('')}
                                </table>`
                    }];
                    // Membuat tabel dinamis untuk Mapel per Kelas (Kelas menyamping)
                    let tabelMapelKelasSuggestions = [{
                        value: `#tabelMapelKelas`,
                        text: `📚 Tabel Mapel per Kelas`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel Mapel Pembagian Jam</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th>Mapel</th>
                                        ${kelasList.map(item => `<th>${item.kelas}</th>`).join('')}
                                    </tr>
                                    ${mapelList.map(item => `
                                                 <tr style='width:100px;text-align:center'>
                                                     <td>${item.mapel}</td>
                                                     ${kelasList.map(kelas => `
                                            <td>${item.kelas_id === kelas.id ? '✓' : ''}</td>
                                    `).join('')}
                                                 </tr>
                                                `).join('')}
                                </table>`
                    }];
                    // Membuat tabel GuruPiket
                    let tabelGuruPiketSuggestions = [{
                        value: `#tabelGuruPiket`,
                        text: `📚 Tabel Guru Piket`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel Guru Piket</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th style='width:30px'>No</th>
                                        <th style='width:150px'>Hari</th>
                                        <th>Nama Guru</th>
                                    </tr>
                                    ${hariList.map((item, index) => `
                                                        <tr style='width:100px;text-align:center'>
                                                            <td style='width:30px'>${index + 1}</td>
                                                            <td>${item ?? ''}</td>
                                                            <td style='width:auto;text-align:left'></td>
                                                        </tr>
                                                    `).join('')}
                                </table>`
                    }];
                    // Membuat tabel Tugas
                    let tabelTugasSuggestions = [{
                        value: `#tabelTugas`,
                        text: `📚 Tabel Tugas`,
                        tableHTML: `
                                <h2 style='text-align:center'> Tabel Tugas Lainnya</h2>
                                <table border="1" style="width: 100%; border-collapse: collapse;">
                                    <tr style='width:100px;text-align:center'>
                                        <th style='width:30px'>No</th>
                                        <th style='width:150px'>Tugas</th>
                                        <th>Nama Guru</th>
                                    </tr>
                                    ${tugasList.map((item, index) => `
                                                        <tr style='width:100px;text-align:center'>
                                                            <td style='width:30px'>${index + 1}</td>
                                                            <td style='width:auto;text-align:left'>${item ?? ''}</td>
                                                            <td style='width:auto;text-align:left'></td>
                                                        </tr>
                                                    `).join('')}
                                </table>`
                    }];

                    // Menambahkan saran untuk hari
                    let hariSuggestions = hariList.map(item => {
                        return {
                            value: `#${item}`,
                            text: `📅 Hari: ${item}`
                        };
                    });

                    // Menggabungkan semua suggestions
                    let allSuggestions = [
                        ...rapatSuggestions,
                        ...guruSuggestions,
                        ...kodeSuggestions,
                        ...ekstraSuggestions,
                        ...tabelekstraSuggestions,
                        ...tabelKelasSuggestions,
                        ...tabelBkSuggestions,
                        ...tabelLabsSuggestions,
                        ...tabelMapelKelasSuggestions,
                        ...tabelGuruPiketSuggestions,
                        ...tabelTugasSuggestions,
                        ...hariSuggestions,
                    ];

                    tinymce.init({
                        selector: ".editor",
                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                        menubar: 'file edit view insert format tools table help',
                        toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table | removeformat fullscreen code | pagebreak',
                        table_sizing_mode: 'relative',
                        table_grid: true,

                        setup: function(editor) {
                            editor.ui.registry.addAutocompleter("customAutocompleter", {
                                trigger: "#",
                                minChars: 1,

                                fetch: function(pattern) {
                                    let filtered = allSuggestions.filter(item =>
                                        item.text.toLowerCase().includes(pattern.toLowerCase())
                                    );

                                    return new Promise((resolve) => {
                                        resolve(filtered);
                                    });
                                },

                                onAction: function(autocompleteApi, rng, value) {
                                    editor.selection.setRng(rng);

                                    // Cek jika ada <h1> kosong, hapus sebelum memasukkan konten
                                    let node = editor.selection.getNode();
                                    if (node.nodeName === "H1" && node.innerHTML.trim() ===
                                        "&nbsp;") {
                                        editor.execCommand('FormatBlock', false,
                                            'p'); // Ubah ke paragraf
                                    }

                                    // Hapus format heading sebelum memasukkan teks
                                    editor.formatter.remove('h1');
                                    editor.formatter.remove('h2');
                                    editor.formatter.remove('h3');

                                    // Hapus kata sebelum trigger `#`
                                    let selection = editor.selection.getRng();
                                    let startContainer = selection.startContainer;

                                    if (startContainer.nodeType === 3) { // Jika teks
                                        let textContent = startContainer.textContent;
                                        let lastHashIndex = textContent.lastIndexOf("#");

                                        if (lastHashIndex !== -1) {
                                            startContainer.textContent = textContent.substring(0,
                                                lastHashIndex);
                                        }
                                    }

                                    // Hapus trigger `#` dari hasil yang dimasukkan
                                    let cleanValue = value.replace(/^#/, ""); // Menghapus tanda '#'

                                    if (cleanValue.startsWith("pagebreak")) {
                                        // Menyisipkan pemisah halaman saat dicetak
                                        editor.insertContent(
                                            '<div style="page-break-before: always;"></div><br>'
                                            );
                                        autocompleteApi.hide();
                                    } else if (cleanValue.startsWith("tabelekstra")) {
                                        let selectedTable = tabelekstraSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabelkelas")) {
                                        let selectedTable = tabelKelasSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabelbk")) {
                                        let selectedTable = tabelBkSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabellabs")) {
                                        let selectedTable = tabelLabsSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabelMapelKelas")) {
                                        let selectedTable = tabelMapelKelasSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabelGuruPiket")) {
                                        let selectedTable = tabelGuruPiketSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("tabelTugas")) {
                                        let selectedTable = tabelTugasSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(selectedTable.tableHTML);
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else if (cleanValue.startsWith("hari")) {
                                        let selectedTable = hariSuggestions[0];

                                        setTimeout(() => {
                                            editor.insertContent(
                                                `<span style="font-weight: normal;">${selectedTable.text}</span>`
                                            );
                                            autocompleteApi.hide();
                                        }, 250);
                                    } else {
                                        setTimeout(() => {
                                            editor.insertContent(
                                                `<span style="font-weight: normal;">${cleanValue}</span>`
                                            );
                                            autocompleteApi.hide();
                                        }, 250);
                                    }
                                }
                            });
                        }
                    });

                });
            </script>









        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='CekDataRapat()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='CekDataRapat()'
 --}}

<script>
    function CekDataRapat(data) {
        var CekDataRapat = new bootstrap.Modal(document.getElementById('CekDataRapat'));
        CekDataRapat.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='CekDataRapat' tabindex='-1' aria-labelledby='LabelCekDataRapat' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelCekDataRapat'>
                    Data Rapat
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tanggal Rapat</th>
                            <th>Nama Rapat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataRapats as $data)
                            <tr class='text-center'>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Carbon::create($data->tanggal_pelaksanaan)->translatedformat('l, d F Y') }}</td>
                                <td>{{ $data->nama_rapat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tanggal Rapat</th>
                            <th>Nama Rapat</th>
                        </tr>
                    </tfoot>
                </table>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                </div>
            </div>

        </div>
    </div>

</div>
