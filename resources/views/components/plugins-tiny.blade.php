@php
        $DataRapats = \App\Models\Program\Rapat\DataRapat::where('tapel_id', $Tapels->id)->get();
        $Kelass = \App\Models\Admin\Ekelas::where('tapel_id', $Tapels->id)->get();
        $DataGuru = \App\Models\User\Guru\Detailguru::get();
        // $Kodes = $DataGuru->kode_guru;
        $DataEkstras = \App\Models\WakaKesiswaan\Ekstra\Ekstra::get();
        $DataMapels = \App\Models\Admin\Emapel::get();
        $DataLabs = \App\Models\Laboratorium\Elaboratorium::get();
@endphp<script>
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
                    let guruList = @json($Gurus);
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