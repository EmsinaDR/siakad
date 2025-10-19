@php
    use PhpOffice\PhpSpreadsheet\IOFactory;

@endphp
<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>


<x-layout>


    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
    @endphp
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btn>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/TambahMapel()</x-btn>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            @php
                // $spreadsheet = IOFactory::load('E:\laragon\www\belphp\amysc\php-excel-upload\apegawai.xls');
                // $sheet = $spreadsheet->getActiveSheet();
                // $data = $sheet->toArray();
                // // dd($data[1][1]);
                // dd($data);

                // dd(count($data));

                // Contoh menampilkan data Excel
                // foreach ($data as $row) {
                // echo implode(', ', $row) . "<br>";
                // }
            @endphp
            <div class='ml-2'>
                <form action="{{ route('upload.excel') }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <label for="file">$Label:</label>
                    <input type="file" name="$name" required>
                    <button type="submit">Upload</button>
                </form>
            </div>
            {{-- {{ dd($chart) }} --}}
            <div style="width: 25%; margin: left;">
                <h3>Contoh Grafik Lingkaran (Pie)</h3>
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
            <script>
                const labels = @json($labels);
                const data = @json($data);

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar', // Bisa juga 'doughnut'
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Penjualan Bulanan',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    }
                });
            </script>






            <!DOCTYPE html>
            <html lang="id">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Jadwal Piket</title>

            </head>
            {{-- class="col-xl-4 col-md-6 col-12 mx-1"  --}}

            <body>
                <input type="color" id="colorPicker" name="color" value="#ff0000">
                <div id="colorPreview" style="width: 100px; height: 100px; background-color: rgba(255, 0, 0, 0.5);">
                </div>
                <input type="color" id="colorPicker" name="color" value="#ff0000">
                <input type="range" min="0" max="100" value="50" id="transparency"
                    style="margin-top: 10px;">
                {{-- <div id="colorPreview" style="width: 100px; height: 100px; background-color: rgba(255, 0, 0, 0.5); margin-top: 10px;"></div> --}}


                <div class="card p-4 data">
                    <h2>Jadwal Piket Mingguan</h2>
                    <h2>Kelas VII A</h2>
                    <div class="row">
                        <div id='senin' width='31%' class='col m-2 p-2' style='background-color:#ebd58b7a'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>SENIN</h2>
                            </div>
                            <ulclaa='mt-2'>
                            <li class='text-left'>Dany</li>
                            <li class='text-left'>Ata</li>
                            <li class='text-left'>Aufa</li>
                            <li class='text-left'>Azmi</li>
                            <li class='text-left'>Aufa</li>
                            <li class='text-left'>Azmi</li>
                            </ulclaa=>
                        </div>
                        <div id='selasa' width='31%' class='col m-2 p-2' style='background-color:#EBD48B'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>SELASA</h2>
                            </div>
                            <ul claa='mt-2'>
                                <li class='text-left'>Dany</li>
                                <li class='text-left'>Ata</li>
                                <li class='text-left'>Aufa</li>
                                <li class='text-left'>Azmi</li>
                            </ul>
                        </div>
                        <div id='rabu' width='31%' class='col m-2 p-2' style='background-color:#EBD48B'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>RABU</h2>
                            </div>
                            <ul claa='mt-2'>
                                <li class='text-left'>Dany</li>
                                <li class='text-left'>Ata</li>
                                <li class='text-left'>Aufa</li>
                                <li class='text-left'>Azmi</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">

                        <div id='kamis' width='31%' class='col m-2 p-2' style='background-color:#EBD48B'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>KAMIS</h2>
                            </div>
                            <ul claa='mt-2'>
                                <li class='text-left'>Dany</li>
                                <li class='text-left'>Ata</li>
                                <li class='text-left'>Aufa</li>
                                <li class='text-left'>Azmi</li>
                            </ul>
                        </div>
                        <div id='jumat' width='31%' class='col m-2 p-2' style='background-color:#EBD48B'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>JUM'AT</h2>
                            </div>
                            <ul claa='mt-2'>
                                <li class='text-left'>Dany</li>
                                <li class='text-left'>Ata</li>
                                <li class='text-left'>Aufa</li>
                                <li class='text-left'>Azmi</li>
                            </ul>
                        </div>
                        <div id='sabtu' width='31%' class='col m-2 p-2' style='background-color:#EBD48B'>
                            <div class='card-header d-flex justify-content-center bg-primary'>
                                <h2 class='card-title'>SABTU</h2>
                            </div>
                            <ul claa='mt-2'>
                                <li class='text-left'>Dany</li>
                                <li class='text-left'>Ata</li>
                                <li class='text-left'>Aufa</li>
                                <li class='text-left'>Azmi</li>
                            </ul>
                        </div>


                    </div>
                </div>

                <script>
                    const colorPicker = document.getElementById('colorPicker');
                    const transparencySlider = document.getElementById('transparency');
                    const colorPreview = document.getElementById('colorPreview');
                    const senin = document.getElementById('senin');
                    const selasa = document.getElementById('selasa');
                    const rabu = document.getElementById('rabu');
                    const kamis = document.getElementById('kamis');
                    const jumat = document.getElementById('jumat');
                    const sabut = document.getElementById('sabut');

                    colorPicker.addEventListener('input', updateColor);
                    transparencySlider.addEventListener('input', updateColor);
                    transparencySlider.addEventListener('senin', updateColor);
                    transparencySlider.addEventListener('selasa', updateColor);
                    transparencySlider.addEventListener('rabu', updateColor);
                    transparencySlider.addEventListener('kamis', updateColor);
                    transparencySlider.addEventListener('jumat', updateColor);
                    transparencySlider.addEventListener('sabtu', updateColor);

                    function updateColor() {
                        const color = colorPicker.value;
                        const transparency = transparencySlider.value / 100;
                        colorPreview.style.backgroundColor =
                            `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        senin.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        selasa.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        rabu.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        rabu.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        kamis.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        jumat.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                        sabtu.style.backgroundColor = `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    }
                </script>
            </body>

            </html>









        </div>

    </section>
</x-layout>
