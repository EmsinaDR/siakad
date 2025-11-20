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
                <div class='col-xl-2'>
                    {{-- <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'><i class='fa fa-plus'></i> Tambah Data </button> --}}
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        <div class="row">
                            <div class="col-xl-3">
                                <form id='#id' action='{{ route('pengeluaran-bos.store') }}' method='POST'>
                                    @csrf
                                    @method('POST')
                                    <div class="card-header bg-primary">
                                        <H3 class="card-title">Input Data Pengeluaran</H3>
                                    </div>
                                    <!-- Pastikan jQuery dan Select2 di-load -->

                                    <!-- Dropdown -->
                                    <div class="form-group my-2">
                                        <label for="jenis_pengeluaran_id">Jenis Pengeluaran</label>
                                        <select id="jenis_pengeluaran_id" class="select2 form-control"
                                            name="jenis_pengeluaran_id" data-placeholder="Cari Pengeluaran..."
                                            onchange="toggleInputPengeluaran(this)" required>
                                            @foreach ($pengerluarans as $newpengerluarans)
                                                <option></option>
                                                <option value="{{ $newpengerluarans->id }}">
                                                    {{ $newpengerluarans->RencanaAnggaranLis->jenis_pengeluaran }} -
                                                    {{ number_format($newpengerluarans->nominal, 2) }}
                                                </option>
                                            @endforeach
                                            <option value="lainnya">Lainnya (Anggaran Tidak Terencana)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="sumber_dana">Sumber Dana</label>
                                        <select name="sumber_dana" id="sumber_dana" class="form-control"
                                            data-placeholder="Pilih Sumber Dana">
                                            <option value="">--- Pilih Sumber Dana ---</option>
                                            @foreach ($sumber_danas as $DataSumber)
                                                <option value="{{ $DataSumber->sumber_dana }}">
                                                    {{ $DataSumber->sumber_dana }} -
                                                    Rp{{ number_format($DataSumber->total, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                            {{-- <option value="other">Lainnya...</option> <!-- Opsi 'Lainnya' --> --}}
                                        </select>

                                    </div>

                                    <!-- Elemen input manual jika "lainnya" dipilih -->
                                    <div id="input_lainnya_pengeluaran" style="display:none;">
                                        {{-- <div id="input_lainnya_pengeluaran"> --}}
                                        <input type="text" name="non_anggaran" id="pengeluaran_manual"
                                            class="form-control" placeholder="Tulis jenis pengeluaran lainnya...">
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
                                        <input type="text" name="pengeluaran_manual" id="pengeluaran_manual"
                                            class="form-control" placeholder="Masukkan Jenis Pengeluaran">
                                    </div>
                                    <div class='form-group my-2'>
                                        <label for='datapenerima'>Nama Penerima Anggaran</label>
                                        <select id='penerimaanggaran' name='penerima_id' class='select2 form-control'
                                            data-placeholder="Pilih Nama Penerima Anggaran" required>
                                            <option value=''>--- Pilih Nama Penerima Anggaran ---</option>
                                            @foreach ($Gurus as $newgurus)
                                                <option value='{{ $newgurus->id }}'>{{ $newgurus->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-inputallin>type:Nominal
                                        Anggaran:Nominal:nominal:id_nominal::Required</x-inputallin>
                                    <x-inputallin>textarea:Keterangan:Keterangan:keterangan:id_keterangan::Required</x-inputallin>
                                    <button type='submit' class='btn btn-default bg-primary btn-md mt-2 float-right'><i
                                            class="fa fa-save"></i> Simpan</button>
                                </form>
                            </div>
                            <div class="col-xl-9">
                                <div class='card-header bg-primary'>
                                    <h3 class='card-title'>Data Riwayat Transaksi</h3>
                                </div>
                                <table id='example1' width='100%'
                                    class='table table-responsive table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center'>
                                            <th class='text-center align-middle' width='1%'>ID</th>
                                            @foreach ($arr_ths as $arr_th)
                                                <th class='text-center align-middle'
                                                    @if ($arr_th === 'Nominal') width='15%' @endif>
                                                    {{ $arr_th }}</th>
                                            @endforeach
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datas as $data)
                                        {{-- @dump($data) --}}
                                            {{-- blade-formatter-disable --}}
                                            @php
                                                $find_RencanaAnggaran = App\Models\Bendahara\RencanaAnggaran::where('id',$data->jenis_pengeluaran_id)->first();
                                                $find_Total_RencanaAnggaran = \App\Models\Bendahara\BOS\TransaksaksiPengeluaranBOS::select('nominal')
                                                    ->where('jenis_pengeluaran_id', $data->jenis_pengeluaran_id)
                                                    ->groupBy('jenis_pengeluaran_id')
                                                    ->sum('nominal');
                                                $total = $find_Total_RencanaAnggaran ?? 0;
                                                $nominal = $find_RencanaAnggaran->nominal ?? 1; // Pastikan tidak membagi dengan 0
                                                $PersenTase = $total / $nominal;
                                                $dataRencanaList = \App\Models\Bendahara\RencanaAnggaranList::where('id', $find_RencanaAnggaran->rencana_anggaran_id)->first();
                                            @endphp
                                            {{-- blade-formatter-enable --}}
                                            <tr>
                                                {{-- blade-formatter-disable --}}
                                                <td class='text-center'>{{ $loop->iteration }}</td>
                                                <td class='text-left'>{{ $dataRencanaList->jenis_pengeluaran }}</td>
                                                <td class='text-left'>Rp. {{ number_format($data->nominal, 2) }} <br> Rp. {{ number_format($total, 2) }}</td>
                                                <td class='text-center'>Rp. {{ number_format($nominal, 0) }}</td>
                                                <td class='text-center'>
                                                    <span class="status-bar badge bg-primary"> {{ number_format($PersenTase * 100, 2) }} % </span>
                                                </td>
                                                {{-- blade-formatter-enable --}}
                                                <script>
                                                    function updateAllBars() {
                                                        const bars = document.querySelectorAll('.status-bar');

                                                        bars.forEach(bar => {
                                                            const text = bar.innerText.trim();
                                                            const percent = parseFloat(text.replace('%', '').replace(',', '.'));

                                                            // Reset class
                                                            bar.className = 'status-bar badge';

                                                            // Tambahkan class sesuai presentase
                                                            if (percent < 50) {
                                                                bar.classList.add('bg-success');
                                                            } else if (percent < 75) {
                                                                bar.classList.add('bg-warning');
                                                            } else {
                                                                bar.classList.add('bg-danger');
                                                            }
                                                        });
                                                    }

                                                    document.addEventListener('DOMContentLoaded', updateAllBars);
                                                </script>

                                                <td class='text-center'> {{ $data->Guru->nama_guru }}</td>


                                                <td width='10%'>
                                                    {{-- blade-formatter-disable --}}
                                                    @if ($data->petugas_id !== Auth::user()->detailguru_id)
                                                    @else
                                                        <div class='gap-1 d-flex justify-content-center'>
                                                            <!-- Button untuk mengedit -->
                                                            <button type='button' class='btn btn-warning btn-sm btn-equal-width'  data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i> </button>
                                                            <!-- Form untuk menghapus -->
                                                            <form id='delete-form-{{ $data->id }}' action='{{ route('pengeluaran-bos.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                            <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                                        </div>
                                                    @endif
                                                    {{-- blade-formatter-enable --}}
                                                    {{-- Modal View Data Akhir --}}

                                                    <div class='modal fade' id='editModal{{ $data->id }}'
                                                        tabindex='-1' aria-labelledby='EditModalLabel'
                                                        aria-hidden='true'>

                                                        <x-edit-modal>
                                                            <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                                            <section>

                                                                {{-- blade-formatter-disable --}}
                                                                <form id='updateurl' action='{{ route('pengeluaran-bos.update', $data->id) }}' method='POST'>
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class='form-group'>
                                                                        <label for='nominal'>Nominal</label>
                                                                        <input type='text' class='form-control' id='nominal' name='nominal' placeholder='Nominal' value='{{ $data->nominal }}' required>
                                                                    </div>
                                                                    <div class='form-group my-2'>
                                                                        <label for='datapenerima'>Nama Penerima Anggaran</label>
                                                                        <select id='penerimaanggaran' name='penerima_id' class='select2 form-control' data-placeholder="Pilih Nama Penerima Anggaran" required>
                                                                            <option value=''>--- Pilih Nama Penerima Anggaran ---</option>
                                                                            @foreach ($Gurus as $newgurus)
                                                                                <option value='{{ $newgurus->id }}' @if($newgurus->id === $data->penerima_id) selected @endif> {{ $newgurus->nama_guru }} </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class='form-group'>
                                                                            <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                                                                            <textarea name='keterangan' id='keterangan' rows='3' class='form-control' placeholder='Masukkan Keterangan Singkat'>{{$data->keterangan}}</textarea>
                                                                        </div>

                                                                    <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'>Kirim</button>
                                                                {{-- blade-formatter-enable --}}
                                                                </form>

                                                            </section>
                                                        </x-edit-modal>
                                                    </div>
                                                    {{-- Modal Edit Data Akhir --}}
                                                    {{-- Modal View --}}

                                                    <div class='modal fade' id='viewModal{{ $data->id }}'
                                                        tabindex='-1' aria-labelledby='ViewModalLabel'
                                                        aria-hidden='true'>


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
            </div>
        </div>
    </section>
</x-layout>
