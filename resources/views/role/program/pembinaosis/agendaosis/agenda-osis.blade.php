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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahKegitan'><i class='fa fa-plus'></i> Tambah Kegiatan</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='exampler' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'>
                                            {{ tgl($data->tanggal_kegiatan, 'l, d F Y') }}
                                        </td>
                                        <td class='text-left'> {{ $data->nama_kegiatan }}</td>
                                        <td class='text-center'> {{ $data->jumlah_peserta }}</td>
                                        <td class='text-center'> {{ $data->lokasi_kegiatan }}</td>
                                        <td class='text-center'>
                                            @switch($data->status_kegiatan)
                                                @case('direncanakan')
                                                    <span class="badge bg-warning p-2">Direncanakan</span>
                                                    @break
                                                @case('berjalan')
                                                    <span class="badge bg-primary p-2">Berjalan</span>
                                                    @break
                                                @case('selesai')
                                                    <span class="badge bg-success p-2">Selesai</span>
                                                    @break
                                                @case('dibatalkan')
                                                    <span class="badge bg-danger p-2">Dibatalkan</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary p-2">-</span>
                                            @endswitch

                                        </td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('agenda-osis.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('agenda-osis.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')
                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='tanggal_kegiatan'>Tanggal Pelaksanaan</label>
                                                                <input type='date' class='form-control' id='tanggal_kegiatan' name='tanggal_kegiatan' value='{{Carbon::create($data->tanggal_kegiatan)->translatedformat('Y-m-d')}}' placeholder='placeholder' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='nama_kegiatan'>Nama Kegiatan</label>
                                                                <input type='text' class='form-control' id='nama_kegiatan' name='nama_kegiatan' value='{{$data->nama_kegiatan}}' placeholder='Nama kegiatan' required>
                                                            </div>
                                                            <div class='form-group'>
                                                               <label for='anggaran'>Anggaran</label>
                                                               <input type='text' class='form-control' id='anggaran' name='anggaran' placeholder='Rencana anggaran' value='{{$data->anggaran ?? ''}}' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='jumlah_peserta'>Jumlah Peserta</label>
                                                                <input type='text' class='form-control' id='jumlah_peserta' name='jumlah_peserta' value='{{$data->jumlah_peserta}}' placeholder='Jumlah peserta' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='lokasi_kegiatan'>Lokasi Kegiatan</label>
                                                                <input type='text' class='form-control' id='lokasi_kegiatan' name='lokasi_kegiatan' value='{{$data->lokasi_kegiatan}}' placeholder='Lokasi tempat pelaksanaan' required>
                                                            </div>
                                                            @php
                                                            $statusKegiatan = ['Direncanakan', 'Berjalan', 'Selesai', 'Dibatalkan'];
                                                            @endphp
                                                            <div class='form-group'>
                                                            <label for='status_kegiatan'>Status Kegiatan</label>
                                                            <select name='status_kegiatan' id='status_kegiatan' data-placeholder='Pilih data status kegiatan' class='select2 form-control' required>
                                                                    <option value=''>--- Pilih Status Kegiatan ---</option>
                                                                @foreach($statusKegiatan as $newkey)
                                                                    <option value='{{$newkey}}' @if($data->status_kegiatan === $newkey) selected @endif>{{$newkey}}</option>
                                                                @endforeach
                                                            </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                    <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                                                                    <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{$data->keterangan}}</textarea>
                                                            </div>
                                                            {{-- blade-formatter-enable --}}

                                                            <button id='kirim' type='submit'
                                                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                                Kirim</button>
                                                        </form>

                                                    </section>
                                                </x-edit-modal>
                                            </div>
                                            {{-- Modal Edit Data Akhir --}}
                                            {{-- Modal View --}}

                                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='ViewModalLabel' aria-hidden='true'>


                                                <x-view-modal>
                                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                                    <section>
                                                        //Content View
                                                    </section>
                                                </x-view-modal>
                                            </div>
                                            {{-- Modal View Akhir --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    {{-- @if ($activecrud === 1) --}}
                                    <th class='text-center'>Action</th>
                                    {{-- @endif --}}
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahKegitan' tabindex='-1' aria-labelledby='LabelTambahKegitan' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahKegitan'>
                    Tambah Kegiatan Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('agenda-osis.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                       <label for='tanggal_kegiatan'>Tanggal Pelaksanaan</label>
                       <input type='date' class='form-control' id='tanggal_kegiatan' name='tanggal_kegiatan' placeholder='placeholder' value='{{Carbon::now()->translatedformat('Y-m-d')}}' required>
                    </div>
                    <div class='form-group'>
                       <label for='nama_kegiatan'>Nama Kegiatan</label>
                       <input type='text' class='form-control' id='nama_kegiatan' name='nama_kegiatan' placeholder='Nama kegiatan' required>
                    </div>
                    <div class='form-group'>
                       <label for='anggaran'>Anggaran</label>
                       <input type='text' class='form-control' id='anggaran' name='anggaran' placeholder='Rencana anggaran' value="{{old('anggaran', $data->anggaran ?? '')}}" required>
                    </div>
                    <div class='form-group'>
                       <label for='jumlah_peserta'>Jumlah Peserta</label>
                       <input type='text' class='form-control' id='jumlah_peserta' name='jumlah_peserta' placeholder='Jumlah peserta' required>
                    </div>
                    <div class='form-group'>
                       <label for='lokasi_kegiatan'>Lokasi Kegiatan</label>
                       <input type='text' class='form-control' id='lokasi_kegiatan' name='lokasi_kegiatan' placeholder='Lokasi tempat pelaksanaan' required>
                    </div>
                    @php
                    $statusKegiatan = ['Direncanakan', 'Berjalan', 'Selesai', 'Dibatalkan'];
                    @endphp
                    <div class='form-group'>
                       <label for='status_kegiatan'>Status Kegiatan</label>
                       <select name='status_kegiatan' id='status_kegiatan' data-placeholder='Pilih data status kegiatan' class='select2 form-control' required>
                               <option value=''>--- Pilih Status Kegiatan ---</option>
                           @foreach($statusKegiatan as $newkey)
                               <option value='{{$newkey}}'>{{$newkey}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'></textarea>
                    </div>
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
<script>
    $(document).ready(function() {
        initDataTable('#exampler', 'Data Kegiatan Osis', '#exampler_wrapper .col-md-6:eq(0)', 2);
    });

    function initDataTable(tableId, exportTitle, buttonContainer, groupByColumn) {
        if ($.fn.DataTable.isDataTable(tableId)) {
            $(tableId).DataTable().destroy();
        }

        var table = $(tableId).DataTable({
            lengthChange: true,
            autoWidth: false,
            responsive: true,
            ordering: true,
            searching: true,
            buttons: [{
                    extend: 'copy',
                    title: exportTitle
                },
                {
                    extend: 'excel',
                    title: exportTitle
                },
                {
                    extend: 'pdf',
                    title: exportTitle,
                    exportOptions: {
                        columns: ':visible:not(.noprint)'
                    }
                },
                {
                    extend: 'colvis',
                    titleAttr: 'Pilih Kolom'
                }
            ],
            columnDefs: [{
                    targets: [],
                    visible: false
                }, // Sembunyikan kolom Action jika perlu
                //{ targets: groupByColumn, visible: true } // Pastikan kolom yang dikelompokkan tetap terlihat
            ],
            //rowGroup: { dataSrc: groupByColumn }
        });

        table.buttons().container().appendTo(buttonContainer);
        $('#exampler_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#exampler_filter input').on('input', function() {
            var value = this.value.trim();
            table.column(value).search(value).draw(); //Kolom Pencarian

            // Jika input kosong, reset pencarian
            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });
    }
</script>
