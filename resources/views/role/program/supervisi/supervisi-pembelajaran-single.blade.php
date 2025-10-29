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
                        <h3 class="text-center"><b>INSTRUMEN PENILAIAN PELAKSANAAN PEMBELAJARAN</b></h3>
                        <h3 class="text-center"><b>TAHUN PELAJARAN {{ $Tapels->tapel }}/ {{ $Tapels->tapel + 1 }}</b>
                        </h3>
                        <hr class='bg-light' style='height: 4px;'>

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
                                        <td width='35%' class='text-left'>
                                            @if($DataMapel->status === 'Sertifikasi')
                                            {{ $DataMapel->status }}
                                            @else
                                            Status
                                            @endif
                                        </td>
                                        <td class='text-left'> :
                                            @if($DataMapel->status === 'Sertifikasi')
                                            {{ $DataMapel->tahun_sertifikasi }} Tahun
                                            @else
                                            {{$DataMapel->status}}
                                            @endif
                                        </td>
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
                                        <td class='text-left'> : {{ $DataMapel->jtm }} Jam/ minggu</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
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
                                @foreach ($Instrumens as $kategori => $subKategoris)
                                    {{-- <tr class="table-info">
                                        <th colspan="5" class="text-left">{{ $kategori }}</th>
                                    </tr> --}}

                                    @foreach ($subKategoris as $subKategori => $subSubKategoris)
                                        <tr class="table-secondary">
                                            <th colspan="5" class="text-left">{{ $subKategori }}</th>
                                        </tr>

                                        @foreach ($subSubKategoris as $subSubKategori => $subSubSubKategoris)
                                            <tr class="table-success">
                                                <th colspan="5" class="text-left">{{ $subSubKategori }}</th>
                                            </tr>

                                            @foreach ($subSubSubKategoris as $data)
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
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <script>
    function editCell(event, id, field) {
        var currentValue = $(event.target).text().trim();

        if (field === 'nilai') {
            currentValue = (currentValue >= 1 && currentValue <= 4) ? currentValue : '1';
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

        // Ubah input menjadi uppercase secara otomatis
        inputField.on('input', function () {
            this.value = this.value.toUpperCase();
        });

        inputField.on('blur', function () {
            saveChange(event, inputField, id, field);
        });

        inputField.on('keydown', function (e) {
            if (field === 'ketersediaan' && !['Y', 'N'].includes(e.key.toUpperCase()) && e.key !== 'Backspace') {
                e.preventDefault();
            }

            if (e.key === 'Enter') {
                saveChange(event, inputField, id, field);
            }
            if (e.key === 'Escape') {
                cancelEdit(event, inputField, currentValue, field);
            }
        });

        if (field === 'ketersediaan' && currentValue === 'Y') {
            $(event.target).css('font-size', '18px');
            $(event.target).css('text-align', 'center');
        }
    }

    function saveChange(event, inputField, id, field) {
        var newValue = inputField.val();

        if (field === 'nilai') {
            newValue = Math.max(1, Math.min(4, newValue));
        }

        $.ajax({
            url: "{{ route('supervisi-pembelajaran.update', '') }}/" + id,
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                field: field,
                value: newValue
            },
            success: function (response) {
                if (response.success) {
                    $(event.target).text(newValue);

                    if (field === 'ketersediaan' && newValue === 'Y') {
                        $(event.target).css('font-size', '18px');
                        $(event.target).css('text-align', 'center');
                    } else {
                        $(event.target).css('font-size', '');
                        $(event.target).css('text-align', '');
                    }
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function () {
                alert('An error occurred while updating the data.');
            }
        });
    }

    function cancelEdit(event, inputField, currentValue, field) {
        $(event.target).text(currentValue);

        if (field === 'ketersediaan' && currentValue === 'Y') {
            $(event.target).css('font-size', '18px');
            $(event.target).css('text-align', 'center');
        }
    }
</script>







                        {{-- <table id="example1" width="100%" class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr class="table-primary text-center align-middle">
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Instrumens as $subKategori => $items)
                                    Sub Kategori Sebagai Judul
                                    <tr class="table-secondary">
                                        <th colspan="5" class="text-left">{{ $subKategori }}</th>
                                    </tr>

                                    @foreach ($items as $data)
                                        <tr class="text-center" data-id="{{ $data->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $data->indikator }}</td>
                                            <td width="10%" class="text-center" data-field="ketersediaan">
                                                {!! $data->ketersediaan === 'Y'
                                                    ? '<i class="fas fa-check text-success"></i>'
                                                    : '<i class="fas fa-times text-danger"></i>' !!}
                                            </td>
                                            <td width="10%" class="text-center" data-field="nilai">
                                                {{ $data->nilai }}</td>
                                            <td width="20%" class="text-center" data-field="keterangan">
                                                {{ $data->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-primary text-center align-middle">
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                </tr>
                            </tfoot>
                        </table> --}}

                        {{-- {{dump($datas)}} --}}
                        {{-- <table id='example1x' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr class='text-center' data-id="{{ $data->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class='text-left'>{{ $data->Indkator->indikator }}</td>
                                        <td width='10%' class='text-center' data-field="ketersediaan">
                                            {!! $data->ketersediaan === 'Y'
                                                ? '<i class="fas fa-check text-success"></i>'
                                                : '<i class="fas fa-times text-danger"></i>' !!}
                                        </td>
                                        <td width='10%' class='text-center' data-field="nilai">{{ $data->nilai }}
                                        </td>
                                        <td width='20%' class='text-justify' data-field="keterangan">
                                            {{ $data->keterangan }}</td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan='2'>Jumlah</td>
                                    <td width='10%' class='text-center'>x</td>
                                    <td width='10%' class='text-center'>x</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class='table-primary text-center align-middle'>
                                    <th>ID</th>
                                    <th>Indikator</th>
                                    <th>Ketersediaan</th>
                                    <th>Nilai</th>
                                    <th>Keterangan</th>
                                </tr>
                            </tfoot>
                        </table>
                        <script>
                            $(document).ready(function() {
                                $('#example1x').on('dblclick', 'td[data-field]', function() {
                                    var $cell = $(this);
                                    var currentText = $cell.text().trim();
                                    var field = $cell.data('field'); // Ambil field dari data-field
                                    var row = $cell.closest('tr');
                                    var rowId = row.data('id');

                                    // Tentukan tipe input
                                    var inputType = (field === 'nilai') ? 'number' : 'text';

                                    // Buat input field untuk pengeditan
                                    var inputField = $('<input>', {
                                        type: inputType,
                                        value: currentText,
                                        class: 'form-control text-center'
                                    }).appendTo($cell.empty()).focus();

                                    // Event saat kehilangan fokus
                                    inputField.on('blur', function() {
                                        var newValue = inputField.val().trim();

                                        if (newValue !== currentText) {
                                            var url = '/program/supervisi/supervisi-pembelajaran/' + rowId;

                                            $.ajax({
                                                url: url,
                                                method: 'PUT',
                                                headers: {
                                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                },
                                                data: {
                                                    field: field,
                                                    value: newValue
                                                },
                                                success: function(response) {
                                                    if (response.success) {
                                                        $cell.text(newValue);
                                                    } else {
                                                        alert('Gagal memperbarui data: ' + (response
                                                            .message || 'Tidak ada pesan error.'));
                                                    }
                                                },
                                                error: function(jqXHR) {
                                                    alert('Terjadi kesalahan saat mengupdate data');
                                                }
                                            });
                                        } else {
                                            $cell.text(currentText);
                                        }
                                    });
                                });
                            });
                        </script> --}}
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
