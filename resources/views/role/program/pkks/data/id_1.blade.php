@php
    use Illuminate\Support\Carbon;

    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
    $image = base64_encode(file_get_contents(public_path('dist/img/user2-160x160.jpg')));
    $imgSrc = 'data:image/png;base64,' . $image;
@endphp
<x-layout-view-pkks>
    <x-slot:judul>BERITA ACARA TUGAS ORGANISASI</x-slot:judul>
    <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
    <section>

        <style>
            #tree {
                width: 100%;
                height: auto;
                display: block;
                margin: 0 auto;
            }

            .orgchart .node {
                font-size: 14px;
                /* Ukuran font agar teks bisa terlihat */
                text-align: center;
                /* Menyelaraskan teks di dalam node */
                display: block;
            }

            .orgchart .node div {
                overflow: visible;
                /* Agar teks bisa terlihat jika lebih panjang */
            }
        </style>
        <script src="https://balkan.app/js/OrgChart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <div id="tree"></div>
        {{-- Bagan JS --}}
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function pdf(nodeId) {
                chart.exportPDF({
                    scale: 50, // Skala untuk memperkecil atau memperbesar ukuran diagram
                    landscape: true, // Orientasi landscape
                    format: "A4", // Format kertas A4
                    header: 'My Header', // Menambahkan header ke PDF
                    footer: 'My Footer. Page {current-page} of {total-pages}', // Footer dengan nomor halaman
                    // expandChildren: true, // Meng-expand anak-anak jika ada
                    // filename: "myChart.pdf", // Nama file PDF
                    // min: false, // Jangan mengurangi ukuran bagan
                    // openInNewTab: true, // Membuka PDF di tab baru setelah diekspor
                    // parentLevels: 1, // Level induk yang akan diekspor
                    // childLevels: 1, // Level anak yang akan diekspor
                    // margin: [10, 10, 10, 10], // Margin halaman PDF
                    // padding: 50, // Padding dalam node
                });
            }

            // Data yang diproses dari Laravel
            var nodes = {!! json_encode(
                $DataStrukturs->map(function ($item) {
                    $imagePath = public_path('dist/img/user2-160x160.jpg'); // Ganti dengan path gambar asli
                    $imageData = base64_encode(file_get_contents($imagePath));
                    $imgSrc = 'data:image/png;base64,' . $imageData; // Format Base64
                    return [
                        'id' => $item->id,
                        'pid' => $item->parent_id, // Hubungan parent-child
                        'tags' => $item->jabatan, // Menggunakan string langsung, bukan array
                        'name' => $item->guru ? $item->guru->nama_guru : 'Tidak Ada Nama',
                        'title' => $item->jabatan,
                        'img' => $imgSrc, // Jika tidak ada foto, gunakan default
                    ];
                }),
            ) !!};

            console.log(nodes); // Memeriksa apakah data sudah dikirim dengan benar

            // Membuat chart dengan OrgChart.js
            var chart = new OrgChart(document.getElementById("tree"), {
                mouseScrool: OrgChart.action.none, //Scrole of
                nodes: nodes,
                enableSearch: false,
                mouseScrool: OrgChart.action.none, // Nonaktifkan scroll mouse

                template: "diva", // ula, diva, mila, polina, ana, mery, rony, isla, deborah
                menu: {
                    export_pdf: {
                        text: "Export PDF - A4",
                        icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                        onClick: pdf
                    },
                },
                enableDragDrop: true, // Enable drag-and-drop
                nodeBinding: {
                    field_0: 'name', // Binding 'name' ke field_0
                    field_1: 'title', // Binding 'title' ke field_1
                    img_0: 'img' // Binding 'img' ke img_0
                }
            });

            chart.onInit(function() {
                this.menuUI.showStickIn(this.getMenuButton());
            });

            // Event Drag & Drop untuk Update parent_id
            chart.on('drop', function(sender, draggedNodeId, newParentId) {
                console.log('Node yang dipindahkan:', draggedNodeId, 'Ke parent baru:', newParentId);

                var updatedNode = {
                    parent_id: newParentId
                };

                $.ajax({
                    url: '/program/pkks/data-view-pkks/' + draggedNodeId, // Sesuaikan ID
                    type: 'PATCH', // Bisa juga PUT kalau route pakai PUT
                    data: {
                        parent_id: newParentId,
                        _token: $('meta[name="csrf-token"]').attr('content') // Kirim CSRF Token
                    },
                    success: function(response) {
                        console.log('Update berhasil:', response);
                    },
                    error: function(xhr) {
                        console.error('Update gagal:', xhr.responseText);
                    }
                });


            });
        </script>














        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        {{-- Struktur Organisasi (Landscape) --}}
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <style>
            /* Halaman Default: Portrait */
            @page {
                size: A4 portrait;
                margin: 1cm;
            }

            /* Halaman Struktur Organisasi: Landscape */
            .page.landscape {
                width: 35cm;
                height: 21cm;
                margin: auto;
                padding: 2cm;
                display: flex;
                flex-direction: column;
                justify-content: center;
                /* align-items: center; */
                box-sizing: border-box;
                page-break-before: always;
            }

            /* Class untuk setiap halaman */
            .page {
                page-break-before: always;
            }

            /* Halaman Struktur Organisasi */
            .landscape {
                page: landscape;
                width: 100%;
                margin: 1cm auto;
                padding: 1cm;
                text-align: left;
                background: white;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            .container {
                width: 100%;
                text-align: left;
            }

            .chart-container {
                width: 110%;
                height: auto;
                /* margin-left: -60px; */
            }

            .page-break {
                page-break-before: always;
            }

            /* Penyesuaian untuk node agar tetap rapi */
            .google-visualization-orgchart-node {
                min-width: 150px;
                min-height: 70px;
                max-width: 300px;
                /* Batasi ukuran agar rapi */
                max-height: 100px;
                /* Tambahkan batasan tinggi agar tetap proporsional */
                white-space: nowrap;
                /* Jangan membungkus teks */
                overflow: hidden;
                /* Sembunyikan teks yang melebihi batas */
                text-overflow: ellipsis;
                /* Tampilkan elipsis jika teks terlalu panjang */
                padding: 5px;
                text-align: center;
                font-size: 14px;
                display: flex;
                justify-content: center;
                align-items: center;
                /* Menjaga posisi teks tetap di tengah */
                flex-wrap: nowrap;
                /* Hindari elemen membungkus */
            }

            /* Penyesuaian garis penghubung jika ada banyak elemen */
            .google-visualization-orgchart-lineleft,
            .google-visualization-orgchart-lineright {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                width: 100%;
                align-items: center;
                /* Menjaga posisi garis agar rapi */
            }

            .org-node {
                max-width: 500px !important;
                text-align: center;
                overflow: hidden;
                text-overflow: ellipsis;
                background-color: lightblue;
                /* Untuk mempermudah identifikasi */
            }


            @media print {
                .content.page.landscape {
                    transform: rotate(-90deg);
                    /* Balik rotasi saat mencetak */
                    transform-origin: top left;
                    page-break-before: always;
                }

                .google-visualization-orgchart-node {
                    font-size: 12px;
                    /* Sesuaikan ukuran font untuk cetakan */
                    padding: 8px;
                    /* Sesuaikan padding agar tidak terlalu padat */
                }

                .google-visualization-orgchart-lineleft,
                .google-visualization-orgchart-lineright {
                    margin: 0 auto;
                    /* Pastikan garis penghubung terpusat saat dicetak */
                }
            }
        </style>

        {{-- Struktur Organisasi (Landscape) --}}
        <div class="content page landscape">
            <h2 class='text-center'>Struktur Organisasi</h2>
            <div id="chart_divx" class="chart-container mt-5"></div>

        </div>

        {{-- Script Google Charts --}}
        <script type="text/javascript">
            google.charts.load('current', {
                packages: ["orgchart"]
            });
            google.charts.setOnLoadCallback(drawChart);

            function singkatNama(nama) {
                if (!nama) return 'Tidak Ada Guru'; // Jika tidak ada nama, return default

                let parts = nama.split(',');
                let namaLengkap = parts[0].trim();
                let gelar = parts.length > 1 ? ', ' + parts[1].trim() : '';

                let namaSplit = namaLengkap.split(' ');

                if (namaSplit.length >= 3) {
                    let singkatan = namaSplit[0] + ' ' + namaSplit.slice(1, -1).map(kata => kata[0] + '.').join(' ') + ' ' +
                        namaSplit[namaSplit.length - 1];
                    return singkatan + gelar;
                }

                return nama + gelar;
            }


            function drawChart() {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Nama');
                data.addColumn('string', 'Atasan');
                data.addColumn('string', 'ToolTip');

                // Ambil data dari Laravel
                var strukturData = @json($DataStrukturs);

                // Buat array untuk menampung data dengan grouping
                var chartData = strukturData.map(item => [{
                        v: item.jabatan,
                        f: `<b>${item.jabatan}</b><br><span>${singkatNama(item.guru ? item.guru.nama_guru : '')}</span><br><small>${item.guru ? item.guru.nip : '-'}</small>`
                    },
                    item.parent_id ? strukturData.find(d => d.id == item.parent_id)?.jabatan : null,
                    ''
                ]);

                data.addRows(chartData);

                var chart = new google.visualization.OrgChart(document.getElementById('chart_divx'));

                // **PENTING**: Atur mode agar bisa membuat struktur multi-level
                chart.draw(data, {
                    allowHtml: true,
                    nodeClass: "org-node"
                });
            }
        </script>

        {{-- Halaman Notulen Rapat (Portrait) --}}
        @foreach ($dataRapats as $dataRapat)
            <div class="container">
                <div class="pagee">
                    <x-kop-surat-cetak></x-kop-surat-cetak>
                    <h3 class="text-center">NOTULEN {{ strtoupper($dataRapat->nama_rapat) }}</h3>
                    <h3 class="text-center">{{ $dataRapat->Tapel->tapel }} - {{ $dataRapat->Tapel->tapel + 1 }}</h3>
                    <p class="text-left">{!! $dataRapat->notulen !!}</p>
                </div>
            </div>
        @endforeach
    </section>

    {{-- Bagan JS --}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div class='bagan'>
        <h2>Struktur Organisasi</h2>
        <div id="chart_div"></div>
    </div>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ["orgchart"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Nama');
            data.addColumn('string', 'Atasan');
            data.addColumn('string', 'ToolTip');

            var strukturData = @json($DataStrukturs);
            var chartData = strukturData.map(item => [{
                    v: item.jabatan,
                    f: `<b>${item.jabatan}</b><br>${item.detailguru_id ? 'ID Guru: ' + item.detailguru_id : ''}`
                },
                item.parent_id ? strukturData.find(d => d.id == item.parent_id)?.jabatan : null,
                ''
            ]);

            data.addRows(chartData);
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            chart.draw(data, {
                allowHtml: true
            });
        }
    </script>




    {{-- Halaman Notulen Rapat (Portrait) --}}
    @foreach ($dataRapats as $dataRapat)
        <div class="container">
            <div class="pagee">
                <x-kop-surat-cetak></x-kop-surat-cetak>
                <h3 class="text-center">NOTULEN {{ strtoupper($dataRapat->nama_rapat) }}</h3>
                <h3 class="text-center">{{ $dataRapat->Tapel->tapel }} - {{ $dataRapat->Tapel->tapel + 1 }}</h3>
                <p class="text-left">{!! $dataRapat->notulen !!}</p>
            </div>
        </div>
    @endforeach



    </section>
    {{-- Bagan JS --}}

</x-layout-view-pkks>
