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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data Penerima</button>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#BulkDoc'><i class='fa fa-file-pdf'></i> Dokumen Siswa</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Pelajaran</th>
                                <th>Total Pemasukkan (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($TotalPemasukkan as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data->Tapel->tapel }} / {{ $data->Tapel->semester ?? '' }}</td>
                                    <td>Rp. {{ number_format($data->total_nominal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data pemasukkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
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
                                    {{-- @if ($activecrud === 1)
                                              {{-- @endif --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        {{-- blade-formatter-disable --}}
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'> {{ $data->Siswa->nama_siswa }} / {{ $data->detailsiswa_id }}</td>
                                        <td class='text-center'> {{ $data->Kelas->kelas ?? '' }}</td>
                                        @php
                                            $Pengeluaran = \App\Models\Bendahara\PIP\PengeluaranBendaharaPip::where('detailsiswa_id',$data->detailsiswa_id,)->sum('pengeluaran');
                                            $Pemasukkan = \App\Models\Bendahara\PIP\PemasukkanBendaharaPip::where('detailsiswa_id', $data->detailsiswa_id)->sum('nominal');
                                            $saldo = $Pemasukkan - $Pengeluaran;
                                        @endphp
                                        <td class='text-center'>Rp. {{ number_format($saldo, 2) }}</td>
                                        <td class='text-center'> {{ $data->Petugas->nama_guru ?? '' }}</td>

                                        {{-- blade-formatter-enable --}}
                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                                   <div class='gap-1 d-flex justify-content-center'>
                                                       <!-- Button untuk mengedit -->
                                                       <button type='button' class='btn btn-success btn-sm btn-equal-width' data-toggle='modal'><i class='fa fa-file-pdf'></i> </button>
                                                       <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('penerima.pip.delete', ['id' => $data->id, 'penerima_pip' => $data->detailsiswa_id]) }}' method='POST' style='display: inline-block;'>
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
                                                            action='{{ route('penerima-pip.update', $data->id) }}'
                                                            method='POST'>
                                                            @csrf
                                                            @method('PATCH')

                                                            contentEdit

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

{{-- <button class='btn btn-warning btn-sm' onclick='TambahData()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='TambahData()'
 --}}

<script>
    function TambahData(data) {
        var TambahData = new bootstrap.Modal(document.getElementById('TambahData'));
        TambahData.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='TambahData' tabindex='-1' aria-labelledby='LabelTambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelTambahData'>
                    Tambah Data Penerima Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('penerima-pip.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' id='id' class='form-control'
                            data-placeholder='Data Penerima PIP Baru' multiple='multiple' required>
                            @foreach ($Siswas->whereNotIn('id', $IDPenerima)->whereNotNull('kelas_id') as $Siswa)
                                <option value='{{ $Siswa->id }}'>{{ $Siswa->nama_siswa }} -
                                    {{ $Siswa->KelasOne->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='BulkDoc()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='BulkDoc()'
 --}}
modalc
<script>
    function BulkDoc(data) {
        var BulkDoc = new bootstrap.Modal(document.getElementById('BulkDoc'));
        BulkDoc.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='BulkDoc' tabindex='-1' aria-labelledby='LabelBulkDoc' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelBulkDoc'>
                    Data Dokumen Siswa
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                    <div class='card'>
                        <div class='card-header bg-success'>
                            <h3 class='card-title'><i class='fas fa-text-width'></i>Informasi</h3>
                        </div><!-- /.card-header -->
                        <div class='card-body'>
                            <dl>
                                <dt>Bagian 1</dt>
                                <dd>- Pilih data siswa untuk dicetak dokumen sebagai syarat pemberkasan</dd>
                                <dd>- Dokumen diantara surat aktiv, ktp orang tua, kartu keluarga, kartu pip</dd>
                            </dl>
                        </div><!-- /.card-body -->
                    </div>

                <form id='#id' action='{{ route('penerima-pip.store') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Nama Siswa</label>
                        <select name='detailsiswa_id[]' id='idBulkDoc' class='form-control'
                            data-placeholder='Data Penerima PIP Baru' multiple='multiple' required>
                            @foreach ($DataPenerima as $penerima)
                                <option value='{{ $penerima->detailsiswa_id }}'>{{ $penerima->Siswa->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
