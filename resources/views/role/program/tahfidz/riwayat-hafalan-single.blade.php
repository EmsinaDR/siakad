@php
    //Tahfidz Riwayat Hafalan
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


            <div class='ml-2 my-4'>
                {{-- Catatan :
                   - Include Komponen Modal CRUD + Javascript / Jquery
                   - Perbaiki Onclick Tombol Modal Create, Edit
                   - Variabel Active Crud menggunakan ID User
                    --}}
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center table-primary'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            <th>Action</th>
                            {{-- @if ($activecrud === 1)
                                         {{-- @endif --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'> {{ $data->siswa->nama_siswa }}</td>
                                <td class='text-center'> {{ $data->surat->nama_surat }}</td>
                                <td class='text-center'>
                                    {{-- blade-formatter-disable --}}
                                    @php
                                        $decodedAyats = json_decode($data->ayat, true) ?? [];
                                    @endphp

                                    @foreach ($decodedAyats as $index => $ayat)
                                        {{ $ayat }}@if (!$loop->last) ,
                                        @endif
                                    @endforeach
                                    {{-- blade-formatter-enable --}}
                                </td>
                                <td class='text-center'> {{ $data->keterangan }}</td>

                                <td width='0%'>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        {{-- blade-formatter-disable --}}
                                         <button type='button' class='btn btn-warning btn-sm btn-equal-width'  data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i> </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('riwayat-hafalan.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                        {{-- blade-formatter-enable --}}
                                    </div>
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                <form id='#id'
                                                    action='{{ route('riwayat-hafalan.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')

                                                    {{-- Peserta --}}
                                                    <div class='form-group'>
                                                        <label for='detailsiswa_id'>Peserta</label>
                                                        <select name='detailsiswa_id'
                                                            id='DataPesertas-{{ $data->id }}' class='form-control'
                                                            required>
                                                            <option value=''>--- Pilih Peserta ---</option>
                                                            @foreach ($DataPesertas as $DataPeserta)
                                                                <option value='{{ $DataPeserta->detailsiswa_id }}'>
                                                                    {{ $DataPeserta->kelas->kelas }} -
                                                                    {{ $DataPeserta->SiswaOne->nama_siswa }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Nama Surat --}}
                                                    <div class="form-group">
                                                        <label for="surat_id">Nama Surat</label>
                                                        <select name="surat_id" id="surat_id-{{ $data->id }}"
                                                            class="form-control" required>
                                                            <option value="">--- Pilih Nama Surat ---</option>
                                                            @foreach ($DataSurats as $DataSurat)
                                                                <option value="{{ $DataSurat->id }}"
                                                                    data-jumlah-ayat="{{ $DataSurat->jumlah_ayat }}">
                                                                    {{ $DataSurat->nama_surat }} - (1 -
                                                                    {{ $DataSurat->jumlah_ayat }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Dropdown Ayat (Multiple) --}}
                                                    <div class="form-group">
                                                        <label for="ayat">Ayat</label>
                                                        <select name="ayat[]" id="ayat-{{ $data->id }}"
                                                            class="form-control" multiple required>
                                                            <!-- Opsi akan diisi oleh JavaScript -->
                                                        </select>
                                                    </div>

                                                    {{-- Keterangan --}}
                                                    <div class='form-group'>
                                                        <i class='fas fa-sticky-note'></i>
                                                        <label for='keterangan'>Keterangan</label>
                                                        <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                                            placeholder='Masukkan Keterangan Singkat'>{{ $data->keterangan }}</textarea>
                                                    </div>

                                                    {{-- Tombol Simpan --}}
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary'
                                                            data-dismiss='modal'>Close</button>
                                                        <button type='submit' class='btn btn-primary'><i
                                                                class='fa fa-save'></i> Simpan</button>
                                                    </div>
                                                </form>

                                                {{-- JavaScript untuk mengisi & memilih data --}}
                                                <script>
                                                    $(document).ready(function() {
                                                        // Set default selected Peserta
                                                        $('#DataPesertas-{{ $data->id }}').val(@json($data->detailsiswa_id)).trigger('change');

                                                        // Set default selected Surat dan load ayat berdasarkan surat_id yang tersimpan
                                                        let selectedSurat = @json($data->surat_id);
                                                        let selectedAyat = @json($data->ayat); // Sudah dalam bentuk array

                                                        $('#surat_id-{{ $data->id }}').val(selectedSurat).trigger('change');

                                                        function loadAyat(suratId) {
                                                            let surat = $('#surat_id-{{ $data->id }} option[value="' + suratId + '"]');
                                                            let jumlahAyat = surat.data('jumlah-ayat');

                                                            let ayatDropdown = $('#ayat-{{ $data->id }}');
                                                            ayatDropdown.empty();

                                                            if (jumlahAyat) {
                                                                for (let i = 1; i <= jumlahAyat; i++) {
                                                                    let isSelected = selectedAyat.includes(i.toString()) ? 'selected' : '';
                                                                    ayatDropdown.append(`<option value="${i}" ${isSelected}>Ayat ${i}</option>`);
                                                                }
                                                            }
                                                        }

                                                        // Load ayat saat pertama kali
                                                        loadAyat(selectedSurat);

                                                        // Update dropdown ayat saat surat berubah
                                                        $('#surat_id-{{ $data->id }}').on('change', function() {
                                                            let newSuratId = $(this).val();
                                                            selectedAyat = []; // Reset ayat terpilih
                                                            loadAyat(newSuratId);
                                                        });
                                                    });
                                                </script>



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

    </section>
</x-layout>
<script>
    $(document).ready(function() {
        initDataTable('#example1', 'Data Peserta Tahfidz', '#example1_wrapper .col-md-6:eq(0)', 2);
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
            //searchCols: [
            //    null,  // Kolom 0 (ID)
            //   { search: '' }, // Kolom 1 (Nama Siswa)
            //    { search: '' }, // Kolom 2 (Kelas)
            //    { search: '' }, // Kolom 3 (Pembimbing)
            //   { search: '' }  // Kolom 4 (Hari Bimbingan)
            //],
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

    }
</script>
