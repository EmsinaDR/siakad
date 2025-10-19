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
        {{-- <div class='card'> --}}
        {{-- Papan Informasi --}}
        {{-- Papan Informasi --}}

        <!--Car Header-->
        <div class='card-header bg-primary mx-2'>
            <h3 class='card-title'>{{ $title }}</H3>
        </div>
        <!--Car Header-->


        <div class='ml-2 my-4'>
            <div class="row">
                <div class="col-xl-3">

                    <div class='small-box bg-info'>
                        <h3 class='m-2'>Komite</h3>

                        {{-- blade-formatter-disable --}}
                        <div class='inner'>
                            <div class=" d-flex justify-content-between">
                                <span>Total Pemasukkan</span><span>Rp.
                                    {{ number_format($data_keuangan_komite, 2) }}</span>
                            </div>
                            <div class=" d-flex justify-content-between">
                                <span>Total Pengeluaran</span><span>Rp. {{ number_format($data_keuangan_komite_keluar, 2) }}</span>
                            </div>
                            <div class=" d-flex justify-content-between">
                                {{-- <span>Kelas IX</span><span>155 Orang</span> --}}
                                <span>Sisa Keuangan</span><span>
                                    @if ($data_keuangan_komite < $data_keuangan_komite_keluar)
                                        <b class='text-danger'>Rp. {{ number_format($data_keuangan_komite - $data_keuangan_komite_keluar, 2) }}</b>
                                    @else
                                        Rp. {{ number_format($data_keuangan_komite - $data_keuangan_komite_keluar, 2) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        {{-- blade-formatter-enable --}}
                        <div class='icon'>
                            <i class='fa fa-wallet'></i>
                        </div>
                        <a href='#' class='small-box-footer'>More info <i
                                class='fas fa-arrow-circle-right'></i></a>
                    </div>

                    <div class="card p-2">
                        {{-- blade-formatter-disable --}}
                        <form id='#id' action='{{ route('pengeluaran-komite.store') }}' method='POST'>
                            @csrf
                            @method('POST')
                            <div class="card-header bg-primary">
                                <H3 class="card-title">Input Data Pengeluaran</H3>
                            </div>
                            <!-- Pastikan jQuery dan Select2 di-load -->

                                <!-- Dropdown -->
                                <div class="form-group my-2">
                                    <label for="jenis_pengeluaran_id">Jenis Pengeluaran</label>
                                    <select id="jenis_pengeluaran_id" class="select2 form-control" name="jenis_pengeluaran_id" data-placeholder="Cari Pengeluaran..."  onchange="toggleInputPengeluaran(this)" required>
                                        @foreach ($pengerluarans as $newpengerluarans)
                                        <option></option>
                                            <option value="{{ $newpengerluarans->id }}">
                                                {{ $newpengerluarans->RencanaAnggaranLis->jenis_pengeluaran }} - {{ number_format($newpengerluarans->nominal, 2) }}
                                            </option>
                                        @endforeach
                                        <option value="lainnya">Lainnya (Anggaran Tidak Terencana)</option>
                                    </select>
                                </div>

                                <!-- Elemen input manual jika "lainnya" dipilih -->
                                <div id="input_lainnya_pengeluaran" style="display:none;">
                                {{-- <div id="input_lainnya_pengeluaran"> --}}
                                    <input type="text" name="non_anggaran" id="pengeluaran_manual" class="form-control" placeholder="Tulis jenis pengeluaran lainnya...">
                                </div>

                                <!-- Script toggle -->
                                <script>
                                    function toggleInputPengeluaran(select) {
                                        const manualInput = document.getElementById('input_lainnya_pengeluaran');
                                        if (select.value === 'lainnya') {
                                            manualInput.style.display = 'block';
                                        } else {
                                            manualInput.style.display = 'none';
                                            document.getElementById('pengeluaran_manual').value = '';
                                        }
                                    }

                                    // Inisialisasi Select2 (cukup sekali)
                                    $(document).ready(function() {
                                        $('.select2').select2();
                                    });
                                </script>

                            <div class="form-group mt-2" id="input_lainnya_pengeluaran" style="display: none;">
                                <label for="pengeluaran_manual">Jenis Pengeluaran Lainnya</label>
                                <input type="text" name="pengeluaran_manual" id="pengeluaran_manual" class="form-control" placeholder="Masukkan Jenis Pengeluaran">
                            </div>
                            <div class='form-group my-2'>
                                <label for='datapenerima'>Nama Penerima Anggaran</label>
                                <select id='penerimaanggaran' name='penerima_id' class='select2 form-control' required>
                                    <option value=''>--- Pilih Nama Penerima Anggaran ---</option>
                                        @foreach($gurus as $newgurus)
                                            <option value='{{$newgurus->id}}'>{{$newgurus->nama_guru}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <x-inputallin>type:Nominal Anggaran:Nominal:nominal:id_nominal::Required</x-inputallin>
                            <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan::Required</x-inputallin>
                            <button type='submit' class='btn btn-default bg-primary btn-md mt-2 float-right'><i class="fa fa-save"></i> Simpan</button>
                        </form>
                        {{-- blade-formatter-enable --}}

                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="card p-2">
                        <div class="card-header bg-success mb-4">
                            <H3 class="card-title">⏳ Riwayat Pengeluaran</H3>
                        </div>
                        <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                            <thead>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th width='5%'>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datas as $data)
                                    <tr>
                                        {{-- blade-formatter-disable --}}
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-left'>
                                            @php
// $dataList = \App\Models\Bendahara\RencanaAnggaranList::find($data->rencanaAnggaran->rencana_anggaran_id)
                                            @endphp
                                            {{App\Models\Bendahara\RencanaAnggaranList::find($data->rencanaAnggaran->rencana_anggaran_id)->jenis_pengeluaran}}

                                        </td>
                                        <td class='text-left'> {{ $data->KomitePengeluaranToDetailguru->nama_guru }}
                                        </td>
                                        @php
                                            $find_RencanaAnggaran = App\Models\Bendahara\RencanaAnggaran::where('id', $data->jenis_pengeluaran_id)->first();
                                        @endphp
                                        <td class='text-center'>Rp. {{ number_format($data->nominal, 0) }} / Rp. {{ number_format($find_RencanaAnggaran->nominal, 0) }}</td>
                                        <td class='text-center'>
                                            @php
                                                $find_Total_RencanaAnggaran = App\Models\Bendahara\KomitePengeluaran::select('nominal',)
                                                    ->where('jenis_pengeluaran_id', $data->jenis_pengeluaran_id)
                                                    ->groupBy('jenis_pengeluaran_id')
                                                    ->sum('nominal');
                                                $total = $find_Total_RencanaAnggaran ?? 0;
                                                $nominal = $find_RencanaAnggaran->nominal ?? 1; // Pastikan tidak membagi dengan 0
                                            @endphp
                                            @if (($total / $nominal) * 100 >= 75)
                                                <span class='bg-danger p-2'>{{ number_format(($total / $nominal) * 100, 0) }}%</span>
                                            @elseif(($total / $nominal) * 100 >= 50)
                                                <span class='bg-warning p-2'>{{ number_format(($total / $nominal) * 100, 0) }}%</span>
                                            @else
                                               <span class='bg-success p-2'>{{ number_format(($total / $nominal) * 100, 0) }}%</span>
                                            @endif
                                        </td>
                                        <td width='15%'>
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                <button type='button' class='btn btn-success btn-sm mr-1' data-toggle='modal' data-target='#viewModal{{ $data->id }}'><i class='fa fa-print'></i></button>
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm mr-1' data-toggle='modal' data-target='#editModal{{ $data->id }}'> <i class='fa fa-edit'></i></button>
                                                <!-- Form untuk menghapus -->
                                                <form id='delete-form-{{ $data->id }}' action='{{ route('pengeluaran-komite.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                            </div>
                                        </td>
                                        {{-- blade-formatter-enable --}}
                                    </tr>
                                    {{-- Modal View Data Akhir --}}
                                    <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                        aria-labelledby='EditModalLabel' aria-hidden='true'>
                                        <x-edit-modal>
                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                            <section>
                                                {{-- blade-formatter-disable --}}
                                                <form id='updateurl'
                                                    action='{{ route('pengeluaran-komite.update', $data->id) }}'
                                                    method='POST'>
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class='form-group'>
                                                        <label for='jenis_pengeluaran'>Jenis Pengeluaran</label>
                                                        {{-- <input type='text' class='form-control' id='jenis_pengeluaran' name='jenis_pengeluaran' placeholder='Jenis Pengeluaran' value='{{$data->RencanaAnggaranLis->jenis_pengeluaran}}' required> --}}
                                                    </div>
                                                    <div class='form-group'>
                                                        <label for='nominal'>Nominal Pengeluaran</label>
                                                        <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal Pengeluaran' value='{{$data->nominal}}' required>
                                                    </div>
                                                    <div class='form-group'>
                                                    <label for='penerima_id'>Guru Penerima</label>
                                                        <select id='penerimax{{ $data->id }}' name='penerima_id' class='form-control' required>
                                                            @foreach($gurus as $guru)
                                                                <option value='{{$guru->id}}'>{{$guru->nama_guru}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <script>
                                                       $(document).ready(function() {
                                                           $('#penerimax{{ $data->id }}').val(@json($data->penerima_id)).trigger('change'); // Mutiple Select Select value in array json
                                                       });
                                                    </script>


{{-- <option value='{{ $guru->id }}' {{ $guru->id == $data->penerima_id ? 'selected' : '' }}>
    {{ $guru->nama_guru }} - {{ $guru->id }}
</option> --}}

                                                    <button id='kirim' type='submit'class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                </form>
                                                {{-- blade-formatter-enable --}}

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
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class='text-center'>
                                    <th width='1%'>ID</th>
                                    @foreach ($arr_ths as $arr_th)
                                        <th class='text-center'> {{ $arr_th }}</th>
                                    @endforeach
                                    <th class='text-center'>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- </div> --}}


    </section>
</x-layout>
