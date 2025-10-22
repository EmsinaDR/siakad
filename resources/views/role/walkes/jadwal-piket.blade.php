<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
    }

    table {
        width: 50%;
        margin: auto;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }

    th {
        background-color: #f4f4f4;
    }



    #divToExport {
        background-image: url(https://marketplace.canva.com/EAE60Tqk3kM/1/0/1600w/canva-merah-muda-ilustrasi-minimalis-jadwal-piket-class-schedule-oUEZMv4670s.jpg) !important;
        background-repeat: none;
        background-size: cover;
        margin-bottom: 350px;

    }

    @media print {
        body {
            -webkit-print-color-adjust: exact;
            /* Chrome, Safari */
            print-color-adjust: exact;
            /* Firefox */
            background-image: url(https://marketplace.canva.com/EAE60Tqk3kM/1/0/1600w/canva-merah-muda-ilustrasi-minimalis-jadwal-piket-class-schedule-oUEZMv4670s.jpg) !important;
            background-repeat: none;
            background-size: cover;
            width: 21cm;
            height: 33cm;
        }
    .row>.dataisi {
        margin-top: -350px;
    }
    }
</style>
<x-layout>
    <script src="{{ app('request')->root() }}/tools/pdfq/html2pdf.bundle.min.js"></script>
    @php
        $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
        $urlroot = app('request')->root();
        $id = request('kelas_id');
        $currentUrl = request()->url();

    @endphp
    <style>
        textarea {
            resize: none,
        }
    </style>
    {{-- {{dd(request('print'))}} --}}
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
            <div class='card-body'>

            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            <a href="{{ $currentUrl }}/print" target="_blank" class="btn btn-primary">Cetak PDF</a>
            <button type="button" onClick="generatePDF()" class="btn-sm btn-danger pull-right">Export to PDF</button>

            <div class='ml-2 my-4'>
                <div class="card">
                    <div class="row">
                        <div class="col-xl-3">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Warna Background</h3>
                            </div>
                            <input type="color" id="colorPicker" name="color" value="#ebd4897a;"><input
                                type="range" min="0" max="100" value="50" id="transparency"
                                style="margin-top: 10px;">
                            <div id="colorPreview" style="width: 100px; height: 100px; background-color: #ebd4897a;">
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Gambar Background</h3>
                            </div>
                            {{-- {{ $_POST['url'] }} --}}
                            <x-inputallin>url:Url Gambar:Url gambar Dari Website :Name:id_Name::Required</x-inputallin>
                        </div>
                        <div class="col-xl-3">
                            <div class='card-header bg-primary'>
                                <h3 class='card-title'>Gambar Background</h3>
                            </div>
                            <label for="fontSelector">Pilih Font:</label>
                            <select class='form-control'id="fontSelector">
                                <option value="Arial, sans-serif">Arial</option>
                                <option value="'Helvetica Neue', Helvetica, sans-serif">Helvetica Neue</option>
                                <option value="'Times New Roman', Times, serif">Times New Roman</option>
                                <option value="Georgia, serif">Georgia</option>
                                <option value="Verdana, Geneva, sans-serif">Verdana</option>
                                <option value="Tahoma, Geneva, sans-serif">Tahoma</option>
                                <option value="'Trebuchet MS', Helvetica, sans-serif">Trebuchet MS</option>
                                <option value="'Courier New', Courier, monospace">Courier New</option>
                                <option value="'Lucida Console', Monaco, monospace">Lucida Console</option>
                                <option value="'Impact', Charcoal, sans-serif">Impact</option>
                                <option value="'Comic Sans MS', cursive, sans-serif">Comic Sans MS</option>
                                <option value="'Palatino Linotype', 'Book Antiqua', Palatino, serif">Palatino Linotype
                                </option>
                                <option value="'Lucida Sans Unicode', 'Lucida Grande', sans-serif">Lucida Sans Unicode
                                </option>
                            </select>
                            <input type="range" id="fontSizeSlider" min="10" max="72" value="24">
                            <script>
                                $(document).ready(function() {
                                    $('#fontSelector').on('change', function() {
                                        var selectedFont = $(this).val(); // Mengambil value font yang dipilih
                                        $('#sampleText').css('font-family', selectedFont); // Mengubah font pada elemen sampleText

                                    });
                                    $('#fontSizeSlider').on('change', function() {
                                        var fontSize = $(this).val();
                                        $('#sampleText').css('font-size', fontSize + 'px');
                                        // $('#fontSizeValue').text(fontSize);
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divToExport" class="card p-4 data mt-5">
                <div class="col text-center">
                    <h2 id='sampleText'><b>Jadwal Piket Mingguan</b></h2>

                    <h2>Kelas VII A</h2>

                </div>
                <div class="row dataisi">
                    <div id='senin' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478)'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>SENIN</h2>
                        </div>
                        <ul class='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>
                    <div id='selasa' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>SELASA</h2>
                        </div>
                        <ul claa='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>
                    <div id='rabu' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>RABU</h2>
                        </div>
                        <ul claa='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>
                </div>
                <div class="row">

                    <div id='kamis' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>KAMIS</h2>
                        </div>
                        <ul claa='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>
                    <div id='jumat' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>JUM'AT</h2>
                        </div>
                        <ul claa='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>
                    <div id='sabtu' width='31%' class='col m-2 p-2'
                        style='background-color:hsla(46, 71%, 73%, 0.478'>
                        <div class='card-header d-flex justify-content-center bg-primary mb-3'>
                            <h2 class='card-title'>SABTU</h2>
                        </div>
                        <ul claa='mt-2'>
                            <li class='text-left p-1'>Dany</li>
                            <li class='text-left p-1'>Ata</li>
                            <li class='text-left p-1'>Aufa</li>
                            <li class='text-left p-1'>Azmi</li>
                        </ul>
                    </div>


                </div>
                <div class='alert alert-info alert-dismissible'>
                    <h5><i class='icon fas fa-info'></i> Information !</h5>
                    <hr>
                    <ol>
                        <l1>1. Dikerjakan sebelum proses pembelajaran</l1>
                        <l1></l1>
                        <l1></l1>
                        <l1></l1>
                        <l1></l1>
                    </ol>
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
                    senin.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    selasa.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    rabu.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    rabu.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    kamis.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    jumat.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                    sabtu.style.backgroundColor =
                        `rgba(${parseInt(color.substring(1, 3), 16)}, ${parseInt(color.substring(3, 5), 16)}, ${parseInt(color.substring(5, 7), 16)}, ${transparency})`;
                }
            </script>
        </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='()'><i class='fa fa-edit right'></i> Edit</button>

<script type="text/javascript">
    function generatePDF() {
        var element = document.getElementById('divToExport');

        var opt = {
            margin: 0,
            filename: @json($title) + '.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2, // Meningkatkan resolusi PDF
                backgroundColor: null, // ✅ Biarkan background tetap ada
                useCORS: true, // ✅ Pastikan gambar/background dari URL luar tetap ada
                logging: true // ✅ Debugging untuk melihat error jika ada
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'portrait',
                precision: '12'
            }
        };

        html2pdf().set(opt).from(element).save();
    }
</script>
