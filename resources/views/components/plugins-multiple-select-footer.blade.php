{{-- JS Multiple Select Tabel Footer --}}
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>



<script>
    $(function() {
        for (let i = 0; i <= 100; i++) {
            let selectId = `#select2-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#select${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_siswa${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_siswa${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 1; i <= 200; i++) {
            let selectId = `#id_multiple${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        let selectId = `#id_single`;

        if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
            $(selectId).select2();
        }
    });

    $(function() {
        let selectId = `#id_detailsiswa_dropdown`;

        if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
            $(selectId).select2();
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_detailsiswa${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_detailguru${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#ayat-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_guru${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_user${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_alumni${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_detailguru${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_status${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    // $(function() {
    //     for (let i = 0; i <= 200; i++) {
    //         let selectId = `#id_piket_kelas${i}`;

    //         if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
    //             $(selectId).select2();
    //         }
    //     }
    // });
    // $(function() {
    //     for (let i = 0; i <= 200; i++) {
    //         let selectId = `#id_petugas_upacara${i}`;

    //         if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
    //             $(selectId).select2();
    //         }
    //     }
    // });
    $(function() {
        //Initialize Select2 Elements
        $('#indikator').select2()

    });
    $(function() {
        $('#detailsiswa_id').select2({
            placeholder: "Pilih Nama Siswa", // supaya default kosong & bisa search
            allowClear: true, // agar bisa dihapus pilihannya
            width: '100%' // jaga-jaga kalau tampilannya aneh
        });
    });

    $(function() {
        //Initialize Select2 Elements
        $('#indikator_edit').select2()

    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#indikator${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });

    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#indikator_edit${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#indikator_edit-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#indikator_edit-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#indikator_edit_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#remove_sub-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#mapel${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#menuselect-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            for (let x = 0; x <= 200; x++) {
                let selectId = `#menuselect-${i}.${x}`;

                if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                    $(selectId).select2();
                }
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#mapel${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#kelas_id${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#subcategory${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        //Initialize Select2 Elements
        $('#kelas_created').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#multiple_id_ekstra').select2()
    });
    $(function() {
        //Initialize Select2 Elements
        $('#jam_ke').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#ejam_ke').select2()

    });
    //Single No Index
    $(function() {
        //Initialize Select2 Elements
        $('#id_detailguru').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_tapel').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_korban').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_pelaku').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_saksi').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_kategori').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_kreditpoint').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_point').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_kronologi').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_status_penanganan').select2()

    });
    $(function() {
        //Initialize Select2 Elements
        $('#id_penanganan').select2()

    });

    //Single No Index

    //Batas generator id
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#menuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#amenuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#bmenuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#cmenuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#dmenuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#emenuselect_${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_detailguru-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_tapel-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_korban-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_pelaku-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_saksi-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_kategori-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_kreditpoint-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_point-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_kronologi-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_status_penanganan-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });
    $(function() {
        for (let i = 0; i <= 200; i++) {
            let selectId = `#id_penanganan-${i}`;

            if ($(selectId).length) { // Cek apakah elemen dengan ID tersebut ada
                $(selectId).select2();
            }
        }
    });

    //Batas generator id
</script>
{{-- JS Multiple Select Footer --}}
