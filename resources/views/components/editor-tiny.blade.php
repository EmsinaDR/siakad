<script>
               // {{-- blade-formatter-disable --}}
               const DataGuru = @json($Gurus);
                    function buatTabelGuru(data) {
                        let html = `<table border="1" cellpadding="4" cellspacing="0" style="border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>NIP</th>
                                </tr>
                            </thead>
                            <tbody>`;

                        data.forEach((guru, index) => {
                            html += `<tr>
                                <td style="text-align: center;width: 2%;">${index + 1}</td>
                                <td style="width: 20%">${guru.nama_guru}</td>
                                <td>${guru.nip}</td>
                            </tr>`;
                        });

                        html += '</tbody></table>';
                        return html;
                    }
                const variableListGuru = DataGuru.map(guru => {
                            return {
                                // key jadi nama kecil tanpa spasi, untuk trigger #dany, #veri, dst.
                                key: 'Guru : '+guru.nama_guru.toLowerCase().split(' ')[0],

                                // label yang tampil di dropdown autocomplete
                                label: 'Guru : ' + guru.nama_guru,

                                // value yang diinsert ke editor kalau dipilih
                                value: guru.nama_guru
                            };
                        });
                const variableListStatic = [
                    { key: 'tabel_guru', label: '📋 Tabel Guru', value: buatTabelGuru(DataGuru) },
                    { key: 'tahun_pelajaran', label: '📘 Tahun Pelajaran' },
                    { key: 'nama_sekolah', label: '🏫 Nama Sekolah' },
                    { key: 'alamat_sekolah', label: '📍 Alamat Sekolah' },
                    { key: 'nama_kepala', label: '👨‍💼 Nama Kepala Sekolah' },
                    { key: 'nip_kepala', label: '🆔 NIP Kepala Sekolah' },
                    { key: 'rekening_sekolah', label: '🆔 Rekening Sekolah' },

                    { key: 'nama_guru', label: '👨‍🏫 Nama Guru' },
                    { key: 'nip_guru', label: '🆔 NIP Guru' },
                    { key: 'alamat_guru', label: '🆔 Alamat Guru' },
                    { key: 'nama_mapel', label: '🆔 Mapel' },

                    { key: 'nomor_surat', label: '✉️ Nomor Surat' },
                    { key: 'perihal_surat', label: '📝 Perihal Surat' },
                    { key: 'acara', label: '📝 Acara' },
                    { key: 'lampiran_surat', label: '📎 Lampiran Surat' },
                    { key: 'tembusan_surat', label: '📬 Tembusan Surat' },
                    { key: 'data_hari', label: '📬 Data Hari' },
                    { key: 'data_link', label: '📬 Data Link' },
                    { key: 'periode', label: '📬 Periode' },
                    { key: 'tanggal_surat', label: '📬 Tanggal Surat' },

                    { key: 'nama_kegiatan', label: '🎯 Nama Kegiatan' },
                    { key: 'waktu_pelaksanaan', label: '🕒 Waktu Pelaksanaan' },
                    { key: 'jam_masuk', label: '🕒 Jam Masuk' },
                    { key: 'jam_pulang', label: '🕒 Jam Masuk' },
                    { key: 'tanggal_pelaksanaan', label: '📅 Tanggal Normal' },
                    { key: 'tanggal_normal', label: '📅 Tanggal Pelaksanaan' },
                    { key: 'tanggal_pelaksanaan_mulai', label: '⏳ Tanggal Mulai' },
                    { key: 'tanggal_pelaksanaan_selesai', label: '🏁 Tanggal Selesai' },
                    { key: 'tempat_pelaksanaan', label: '🏁 Tempat Pelaksanaan' },
                    { key: 'jumlah_hari', label: '🏁 Jumlah Hari' },
                    { key: 'jam_operasional', label: '🏁 Jam Operasional' },

                    { key: 'nama_siswa', label: '👦 Nama Siswa' },
                    { key: 'kelas_siswa', label: '🏷️ Kelas Siswa' },
                    { key: 'alamat_siswa', label: '🏠 Alamat Siswa' },
                    { key: 'tempat_lahir_siswa', label: '🗺️ Tempat Lahir' },
                    { key: 'tanggal_lahir_siswa', label: '🎂 Tanggal Lahir' },
                    { key: 'nama_ibu', label: '👩 Nama Ibu' },
                    { key: 'pekerjaan_ibu', label: '🧹 Pekerjaan Ibu' },
                    { key: 'tingkat_siswa', label: '🧹 Tingkat Siswa' },
                    { key: 'tingkat_dropdown', label: '🧹 Tingkat' },
                    { key: 'penerima_surat', label: '📝 Penerima Surat' },
                ];
                const variableList = [...variableListStatic, ...variableListGuru];

                // {{-- blade-formatter-enable --}}

                // Pastikan TinyMCE sudah diinisialisasi saat halaman dimuat
                document.addEventListener('DOMContentLoaded', function() {
                    tinymce.init({
                        selector: '.editor', // Pastikan selector sesuai dengan textarea yang diinginkan
                        height: 1000, // Atur tinggi editor sesuai keinginan
                        branding: false,
                        menubar: 'file edit view insert format tools table help',
                        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table pagebreak',
                        toolbar: 'undo redo | formatselect | bold italic underline strikethrough backcolor | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | link image media table | removeformat fullscreen code | pagebreak',

                        setup: function(editor) {
                            // Buat suggestion autocomplete variabel
                            const variableSuggestions = variableList.map(function(item) {
                            return {
                                // 'value' ini adalah teks yang akan dipakai untuk trigger autocomplete,
                                // biasanya pengguna akan ketik '#' diikuti key, contoh: '#tahun_pelajaran'
                                value: '#' + item.key,

                                // 'text' ini label yang muncul di dropdown autocomplete,
                                // biasanya user lihat ini buat milih variabel yang diinginkan,
                                // misalnya: '📘 Tahun Pelajaran'
                                text: item.label,

                                // 'insertValue' ini isi yang bakal disisipkan ke editor saat user pilih variabel.
                                // Kalau 'item.value' ada, pakai itu (misalnya kalau mau insert HTML lengkap),
                                // kalau tidak ada, pakai format standar '@{{key}}' sebagai placeholder templating.
                                insertValue: item.value || '@{{' + item.key + '}}'
                            };
                        });



                            editor.ui.registry.addAutocompleter('customVariables', {
                                ch: '#',
                                minChars: 1,
                                fetch: function(pattern) {
                                    return new Promise(function(resolve) {
                                        const matches = variableSuggestions.filter(function(
                                            s) {
                                            return s.value.toLowerCase().includes(
                                                pattern.toLowerCase());
                                        });
                                        resolve(matches);
                                    });
                                },
                                onAction: function(autocompleteApi, rng, value) {
                                    const selected = variableSuggestions.find(function(s) {
                                        return s.value === value;
                                    });
                                    editor.selection.setRng(rng);
                                    // Gunakan insertValue, jangan value
                                    if (selected && selected.insertValue) {
                                        editor.insertContent(selected.insertValue);
                                    } else {
                                        editor.insertContent(value);
                                    }
                                    autocompleteApi.hide();
                                }

                            });

                            editor.on('change', function() {
                                editor.save(); // Menyimpan perubahan di TinyMCE ke dalam textarea
                            });
                        }
                    });
                });
</script>