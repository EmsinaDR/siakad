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
        <div class='card'>
            {{-- Papan Informasi --}}
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class="row p-2">
                <div class="col-xl-2">
                    <button class='btn btn-warning btn-block btn-sm' data-toggle='modal' data-target='#tambahData'><i
                            class='fa fa-plus right'></i> Tambah Data</button>
                </div>
                <div class="col-xl-10"></div>
            </div>


            {{-- Modal Edit Data Awal --}}
            <div class='modal fade' id='tambahData' tabindex='-1' aria-labelledby='LabeltambahData' aria-hidden='true'>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>
                        <div class='modal-header bg-primary'>
                            <h5 class='modal-title' id='LabeltambahData'>
                                Tambah Data Baru
                            </h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <form id='#id' action='{{ route('pemasukkan-bos.store') }}' method='POST'>
                                @csrf
                                @method('POST')
                                <div class='form-group'>
                                    <label for='nominal'>Nominal</label>
                                    <input type='text' class='form-control' id='nominal' name='nominal'
                                        placeholder='Nominal' required>
                                </div>
                                <div class="form-group">
                                    <label for="sumber_dana_create">Sumber Dana</label>
                                    <select id="sumber_dana_create" name="sumber_dana" class="form-control" required>
                                        <option value="">--- Pilih Sumber Dana ---</option>
                                        @foreach ($sumber_danas as $sumber_dana)
                                            <option value="{{ $sumber_dana }}"
                                                {{ old('sumber_dana') == $sumber_dana ? 'selected' : '' }}>
                                                {{ $sumber_dana }}
                                            </option>
                                        @endforeach
                                        <option value="other" {{ old('sumber_dana') == 'other' ? 'selected' : '' }}>
                                            Lainnya...</option>
                                    </select>
                                </div>

                                <div class="form-group" id="sumber_dana_other_container" style="display: none;">
                                    <label for="sumber_dana_other">Sumber Dana Lainnya Khusus Terkait BOS</label>
                                    <input type="text" name="other_sumber_dana" id="sumber_dana_other"
                                        class="form-control" placeholder="Masukkan sumber dana lainnya"
                                        value="{{ old('other_sumber_dana') }}">
                                </div>
                                <div class='form-group'>
                                    <i class='fas fa-sticky-note'></i><label for='keterangan'>Keterangan</label>
                                    <textarea name='keterangan' id='keterangan' rows='3' class='form-control'
                                        placeholder='Masukkan Keterangan Singkat'></textarea>
                                </div>

                                <script>
                                    // Cek apakah event listener bekerja
                                    function toggleOtherInput() {
                                        const sumberDanaSelect = document.getElementById('sumber_dana_create');
                                        const otherInputContainer = document.getElementById('sumber_dana_other_container');
                                        console.log('Dropdown berubah, nilai terpilih:', sumberDanaSelect.value); // Debug

                                        if (sumberDanaSelect.value === 'other') {
                                            console.log('Menampilkan input lainnya'); // Debug
                                            otherInputContainer.style.display = 'block';
                                        } else {
                                            console.log('Menyembunyikan input lainnya'); // Debug
                                            otherInputContainer.style.display = 'none';
                                        }
                                    }

                                    // Jalankan saat DOM siap
                                    $(document).ready(function() {
                                        console.log("Dokumen siap"); // Debug
                                        $('#sumber_dana_create').on('change', function() {
                                            toggleOtherInput(); // Debug
                                        });

                                        // Re-trigger saat modal muncul
                                        $('#tambahData').on('shown.bs.modal', function() {
                                            console.log("Modal terbuka"); // Debug
                                            toggleOtherInput(); // Menyesuaikan tampilan ketika modal muncul
                                        });
                                    });
                                </script>

                                <button id='kirim' type='submit'
                                    class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                    Kirim</button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>

            <div class='ml-2 my-4'>
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Pemasukkan</th>
                            <th>Sumber Dana</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-center'>{{ $data->Tapel->tapel }} - {{ $data->Tapel->tapel + 1 }}</td>
                                <td class='text-center'>{{ $data->Tapel->semester }}</td>
                                <td class='text-center'>Rp. {{ number_format($data->nominal, 0) }}</td>
                                <td class='text-center'>{{ $data->sumber_dana }}</td>
                                <td class='text-center'>{{ $data->keterangan }}</td>
                                <td>
                                    {{-- blade-formatter-disable --}}
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width' data-toggle='modal' data-target='#editModal{{ $data->id }}'><i class='fa fa-edit'></i>
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}' action='{{ route('pemasukkan-bos.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width' onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i> </button>
                                    </div>
                                    {{-- blade-formatter-enable --}}
                                </td>
                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='updateEdata' action='{{ route('pemasukkan-bos.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('PATCH')
                                            <div class='form-group'>
                                                <label for='nominal'>Nominal</label>
                                                <input type='text' class='form-control' id='nominal' name='nominal'
                                                    placeholder='Nominal' value='{{ $data->nominal }}' required>
                                            </div>
                                            <div class="form-group">
                                                <label for="sumber_dana">Sumber Dana</label>
                                                <select name="sumber_dana" id="sumber_dana" class="form-control"
                                                    required>
                                                    <option value="">--- Pilih Sumber Dana ---</option>
                                                    @foreach ($sumber_danas as $sumber_dana)
                                                        <option value="{{ $sumber_dana }}"
                                                            @if ($data->sumber_dana == $sumber_dana) selected @endif>
                                                            {{ $sumber_dana }}
                                                        </option>
                                                    @endforeach
                                                    {{-- <option value="other">Lainnya...</option> <!-- Opsi 'Lainnya' --> --}}
                                                </select>
                                            </div>


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
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Tahun Pelajaran</th>
                            <th>Semester</th>
                            <th>Pemasukkan</th>
                            <th>Sumber Dana</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <div class="col-xl-6">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Pemasukkan</h3>
                        </div>
                        <div class='card-body'>
                            <table id='example1' width='100%' class='table table-bordered table-hover'>
                                <thead>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>Pemasukkan</th>
                                        <th>Pengeluaran</th>
                                        <th>Sisa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- blade-formatter-disable --}}
                                    @foreach ($datas as $data)
                                        <tr>
                                            <td class='text-center'>{{ $loop->iteration }}</td>
                                            <td class='text-center'>{{ $data->Tapel->tapel }} - {{ $data->Tapel->tapel + 1 }}</td>
                                            <td class='text-center'>Rp. {{ number_format($data->nominal, 0) }}</td>
                                            @php
                                            $DataBosPengeluaran = \App\Models\Bendahara\BOS\PengeluaranBOS::where('tapel_id', $Tapels->id)->where('keuangan_bos_id', $data->id)->sum('nominal');
                                            $saldo = $data->nominal - $DataBosPengeluaran;
                                            @endphp
                                            <td class='text-center'>Rp. {{ number_format($DataBosPengeluaran, 0) }}</td>
                                            <td @if($saldo<0) class='text-center text-danger' @endif class='text-center text-success' >Rp. {{ number_format($saldo, 0) }}</td>
                                        </tr>
                                    @endforeach
                                    {{-- blade-formatter-enable --}}

                                </tbody>
                                <tfoot>
                                    <tr class='text-center align-middle'>
                                        <th>ID</th>
                                        <th>Tahun Pelajaran</th>
                                        <th>Pemasukkan</th>
                                        <th>Pengeluaran</th>
                                        <th>Sisa</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class='card-header bg-primary'>
                            <h3 class='card-title'>Data Pengeluaran</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </section>
</x-layout>
