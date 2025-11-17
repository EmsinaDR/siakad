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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#TambahData'><i class='fa fa-plus'></i> Tambah Data</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' ><i class='fa fa-print'></i> Cetak All Formulir</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>
                    <table id='exampleOsis' width='100%' class='table table-responsive table-bordered table-hover'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Tahun Pelaajran</th>
                                <th>Jumlah Anggota</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($jumlahPerTapel as $item)
                                <tr>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'>{{ $item->Tapel->tapel }}</td> {{-- Tampil id tapel dulu --}}
                                    <td class='text-center'>{{ $item->total }}</td> {{-- Jumlah anggota --}}
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Tahun Pelaajran</th>
                                <th>Jumlah Anggota</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
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
                                        <td class='text-center' width='10%'> {{ $data->Tapel->tapel }}</td>
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }}</td>
                                        <td class='text-center' width='10%'> {{ $data->Kelas->kelas }}</td>
                                        <td class='text-center' width='10%'>
                                           @switch($data->validasi)
                                               @case(Null)
                                                   <span class='badge bg-warning p-2'>Belum Disetujui</span>
                                                   @break
                                               @default
                                                   <span class='badge bg-secondary p-2'>-</span>
                                           @endswitch
                                        </td>
                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('pendaftaran-osis.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                           @csrf
                                                           @method('DELETE')
                                                       </form>
                                                       <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>  </button>
                                                   </div>
                                                   {{-- blade-formatter-enable --}}
                                            {{-- Modal View Data Akhir --}}

                                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                                aria-labelledby='EditModalLabel' aria-hidden='true'>

                                                <x-edit-modal>
                                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                    <section>
                                                        <form id='updateurl'
                                                            action='{{ route('pendaftaran-osis.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            {{-- blade-formatter-disable --}}
                                                            <div class='form-group'>
                                                                <label for='detailsiswa_id'>Nama Siswa</label>
                                                                <select name='detailsiswa_id' id='detailsiswa_id' data-placeholder='Pilih Data Siswa' class='select2 form-control' required>
                                                                        <option value=''>--- Pilih Nama Siswa ---</option>
                                                                    @foreach($Siswas as $newSiswas)
                                                                        <option value='{{$newSiswas->id}}' @if($data->detailsiswa_id === $newSiswas->id) selected @endif>{{$newSiswas->nama_siswa}} - {{$newSiswas->KelasOne->kelas}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='tujuan'>Tujuan</label>
                                                                <input type='text' class='form-control' id='tujuan' name='tujuan'  value='{{$data->tujuan}}' placeholder='Tujuan Mengikuti Osis' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='moto_hidup'>Moto Hidup</label>
                                                                <input type='text' class='form-control' id='moto_hidup' name='moto_hidup' value='{{$data->moto_hidup}}' placeholder='Moto hidup' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='visi'>Visi Mengikuti Osis</label>
                                                                <input type='text' class='form-control' id='visi' name='visi'  value='{{$data->visi}}' placeholder='Visi Mengikuti Osis Osis' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label for='misi'>Misi Mengikuti Osis</label>
                                                                <input type='text' class='form-control' id='misi' name='misi'  value='{{$data->misi}}' placeholder='Misi Mengikuti Osis osis' required>
                                                            </div>
                                                            <div class='form-group'>
                                                                <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                                                                <textarea name='keterangan' id='keterangan' rows='3' class='form-control' value='{{$data->xxxx}}' placeholder='Masukkan Keterangan Singkat'>{{$data->keterangan}}</textarea>
                                                            </div>
                                                            <div class='modal-footer'>
                                                                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                                                            </div>
                                                            {{-- blade-formatter-enable --}}
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
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                <form id='TambahData-form' action='{{ route('pendaftaran-osis.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    {{-- blade-formatter-disable --}}
                    <div class='form-group'>
                       <label for='detailsiswa_id'>Nama Siswa</label>
                       <select name='detailsiswa_id' id='detailsiswa_id' data-placeholder='Pilih Data Siswa' class='select2 form-control' required>
                               <option value=''>--- Pilih Nama Siswa ---</option>
                           @foreach($Siswas as $newSiswas)
                               <option value='{{$newSiswas->id}}'>{{$newSiswas->nama_siswa}} - {{$newSiswas->KelasOne->kelas}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                        <label for='tujuan'>Tujuan</label>
                        <input type='text' class='form-control' id='tujuan' name='tujuan'  placeholder='Tujuan Mengikuti Osis' required>
                    </div>
                    <div class='form-group'>
                        <label for='moto_hidup'>Moto Hidup</label>
                        <input type='text' class='form-control' id='moto_hidup' name='moto_hidup' placeholder='Moto hidup' required>
                    </div>
                    <div class='form-group'>
                        <label for='visi'>Visi Mengikuti Osis</label>
                        <input type='text' class='form-control' id='visi' name='visi'  placeholder='Visi Mengikuti Osis Osis' required>
                    </div>
                    <div class='form-group'>
                        <label for='misi'>Misi Mengikuti Osis</label>
                        <input type='text' class='form-control' id='misi' name='misi'  placeholder='Misi Mengikuti Osis osis' required>
                    </div>
                    <div class='form-group'>
                        <i class='fas fa-sticky-note pr-2'></i><label for='keterangan'>Keterangan</label>
                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'></textarea>
                    </div>
                    <div class='modal-footer'>
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
        initDataTable('#example1', 'Data Pendaftaran Anggota Osis', '#example1_wrapper .col-md-6:eq(0)', 2);
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
        $('#example1_filter input').attr('placeholder', 'Tuliskan nama...');

        // ✅ Pencarian yang bekerja termasuk untuk tombol 'X'
        $('#example1_filter input').on('input', function() {
            var value = this.value.trim();
            table.columns().search(''); // reset dulu semua kolom search
            table.columns(2).search(value).draw(); // search hanya di kolom 1 & 2

            if (value === '') {
                table.search('').columns().search('').draw();
            }
        });



    }
</script>
