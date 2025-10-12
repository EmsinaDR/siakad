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


            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='RuangTest()'> <i
                            class='fa fa-cog'></i> Set Ruang Test</button>
                    <a href="#" id="resetRuanganBtn">
                        <button type='button' class='btn btn-block btn-default bg-primary btn-md'>
                            <i class='fa fa-recycle'></i> Reset Ruang Test
                        </button>
                    </a>

                    <script>
                        document.getElementById('resetRuanganBtn').addEventListener('click', function(event) {
                            event.preventDefault(); // Mencegah link langsung diakses

                            Swal.fire({
                                title: "Apakah Anda yakin?",
                                text: "Data ruangan akan direset!",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Ya, reset!",
                                cancelButtonText: "Batal"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "{{ route('reset.ruangan.test') }}"; // Redirect jika dikonfirmasi
                                }
                            });
                        });
                    </script>


                </div>
                <div class='col-xl-10'>
                    <div class='card-header bg-success'>
                        <h3 class='card-title'>Data Siswa Dalam Ruangan</h3>
                    </div>
                    <table id='example1' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-center align-middle table-success'>
                                <th width='1%'>ID</th>
                                <th>Ruangan</th>
                                <th>Jumlah Siswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $DataInRuang = $datas->groupBy('nomor_ruangan');
                            @endphp
                            @foreach ($DataInRuang as $nomor_ruangan => $peserta)
                                <tr class='text-center align-middle'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Ruang {{ $nomor_ruangan }}</td>
                                    <td>{{ $peserta->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='text-center align-middle'>
                                <th>ID</th>
                                <th>Ruangan</th>
                                <th>Jumlah Siswa</th>
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
                        <div class="col-xl-12">
                            <div class="col-xl-12">
                                <table id='example1' width='100%' class='table table-bordered table-hover'>
                                    <thead>
                                        <tr class='text-center'>
                                            <th width='1%'>No</th>
                                            <th>Kelas VII <br>( No Ruangan / Kelas / Nama )</th>
                                            <th>Kelas VIII <br>( No Ruangan / Kelas / Nama )</th>
                                            <th>Kelas IX <br>( No Ruangan / Kelas / Nama )</th>
                                            <th>Ruang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $max_rows = max(
                                                count($datas_kelas_vii),
                                                count($datas_kelas_viii),
                                                count($datas_kelas_ix),
                                            );
                                        @endphp

                                        @for ($i = 0; $i < $max_rows; $i++)
                                            <tr>
                                                <td width='1%' class='text-center'>{{ $i + 1 }}</td>
                                                <td class="{{ isset($datas_kelas_vii[$i]) ? '' : 'table-danger' }}">
                                                    {{ $datas_kelas_vii[$i]->nomor_ruangan ?? '-' }} /
                                                    <input type="hidden" class="id-input"
                                                        data-index="{{ $i }}" name="nomor_ruangan_vii[]"
                                                        value="{{ $datas_kelas_vii[$i]->id ?? '-' }}">
                                                    {{ $datas_kelas_vii[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                    {{ $datas_kelas_vii[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                </td>
                                                <td class="{{ isset($datas_kelas_viii[$i]) ? '' : 'table-danger' }}">
                                                    {{ $datas_kelas_viii[$i]->nomor_ruangan ?? '-' }} /
                                                    <input type="hidden" class="id-input"
                                                        data-index="{{ $i }}" name="nomor_ruangan_viii[]"
                                                        value="{{ $datas_kelas_viii[$i]->id ?? '-' }}">
                                                    {{ $datas_kelas_viii[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                    {{ $datas_kelas_viii[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                </td>
                                                <td class="{{ isset($datas_kelas_ix[$i]) ? '' : 'table-danger' }}">
                                                    {{ $datas_kelas_ix[$i]->nomor_ruangan ?? '-' }} /
                                                    <input type="hidden" class="id-input"
                                                        data-index="{{ $i }}" name="nomor_ruangan_ix[]"
                                                        value="{{ $datas_kelas_ix[$i]->id ?? '-' }}">
                                                    {{ $datas_kelas_ix[$i]->PesertaTestToKelas->kelas ?? '' }} /
                                                    {{ $datas_kelas_ix[$i]->PesertaTestToDetailSiswa->nama_siswa ?? '-' }}
                                                </td>
                                                <td width='10%'>
                                                    @php $ruang = range(1, 50); @endphp
                                                    <div class="form-group">
                                                        <select name="ruang_test[]" class="form-control ruang-test"
                                                            data-index="{{ $i }}" required>
                                                            <option value=""></option>
                                                            @foreach ($ruang as $newkey)
                                                                <option value="{{ $newkey }}">
                                                                    {{ $newkey }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='RuangTest()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--

 --}}

<script>
    function RuangTest(data) {
        var RuangTest = new bootstrap.Modal(document.getElementById('RuangTest'));
        RuangTest.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='RuangTest' tabindex='-1' aria-labelledby='LabelRuangTest' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelRuangTest'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('update.ruangan.test') }}' method='POST'>
                    @csrf
                    @method('POST')
                    @php $ruang = range(1, 50); @endphp
                    <div class="form-group">
                        <label for="nomor_ruangan">Ruang Test</label>
                        <select name="nomor_ruangan" class="form-control" placeholder='Pilih data ruangan' required>
                            <option value="">Pilih Ruang Test ex:1</option>
                            @foreach ($ruang as $newkey)
                                <option value="{{ $newkey }}"> {{ $newkey }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class='form-group'>
                        <label for='tingkat'>Pilih Tingkat</label>
                        <select id='tingkat' class='form-control' required>
                            <option value=''>Pilih Tingkat</option>
                            <option value='7'>Tingkat 7</option>
                            <option value='8'>Tingkat 8</option>
                            <option value='9'>Tingkat 9</option>
                        </select>
                    </div>

                    <div class='form-group'>
                        <label for='detailsiswa_id'>Data Siswa</label>
                        <select id='select2-5' name='siswa_ids[]' class='form-control'
                            data-placeholder='Pilih data siswa' multiple='multiple' required disabled>
                            <!-- Data siswa akan dimuat dengan AJAX -->
                        </select>
                    </div>

                    <script>
                        $(document).ready(function() {
                            // Pastikan dropdown siswa tidak bisa diklik sebelum tingkat dipilih
                            $('#select2-5').prop("disabled", true).select2({
                                placeholder: "Pilih data siswa",
                                allowClear: true
                            });

                            $('#tingkat').on('change', function() {
                                let tingkat_id = $(this).val(); // Ambil nilai tingkat yang dipilih

                                // Kosongkan select2 sebelum load data baru
                                $('#select2-5').empty().trigger('change').prop("disabled", true);

                                if (tingkat_id) {
                                    $.ajax({
                                        url: "/get-siswa-by-tingkat/" + tingkat_id, // Route ke controller
                                        type: "GET",
                                        data: {
                                            tingkat_id: tingkat_id
                                        },
                                        success: function(data) {
                                            // Tambahkan opsi siswa ke dalam select2
                                            $.each(data, function(index, siswa) {
                                                let option = new Option(siswa.kelas + " - " + siswa
                                                    .nama_siswa, siswa.id, false, false);
                                                $('#select2-5').append(option);
                                            });

                                            // Aktifkan select2 setelah data siswa dimuat
                                            $('#select2-5').prop("disabled", false).trigger('change');
                                        }
                                    });
                                }
                            });
                        });
                    </script>



                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
{{-- <button class='btn btn-warning btn-sm' onclick='ResetRuang()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='ResetRuang()'
 --}}

<script>
    function ResetRuang(data) {
        var ResetRuang = new bootstrap.Modal(document.getElementById('ResetRuang'));
        ResetRuang.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ResetRuang' tabindex='-1' aria-labelledby='LabelResetRuang' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelResetRuang'>
                    Set Data Siswa Diruangan
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form id='#id' action='{{ route('reset.ruangan.test') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                        <label for='detailsiswa_id'>Data Siswa</label>
                        <select id='select2-5' name='siswa_ids[]' class='select2 form-control'
                            dataplaceholde='Tambah siswa kedalam ruangan' data-placeholder='Pilih data siswa'
                            multiple='multiple' required>
                            @foreach ($SiswaDropdown as $newSiswaDropdown)
                                <option value='{{ $newSiswaDropdown->id }}'>{{ $newSiswaDropdown->Kelas->kelas }} -
                                    {{ $newSiswaDropdown->Siswa->nama_siswa }}</option>
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
        <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
            <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
        </div>
    </div>
</div>

</div>
<script>
    $(document).ready(function() {
        $(document).off('change', '.ruang-test').on('change', '.ruang-test', function() {
            var select = $(this);
            select.prop('disabled', true);

            var ruang_test = select.val();
            var index = select.data('index');
            var siswa_ids = [];

            // Mengumpulkan siswa IDs
            var siswa_id_vii = $('.id-input[data-index="' + index + '"]:eq(0)').val();
            var siswa_id_viii = $('.id-input[data-index="' + index + '"]:eq(1)').val();
            var siswa_id_ix = $('.id-input[data-index="' + index + '"]:eq(2)').val();

            // Pastikan ID tidak kosong sebelum dimasukkan ke dalam array
            if (siswa_id_vii !== '-' && siswa_id_vii !== '') {
                siswa_ids.push(siswa_id_vii);
            }
            if (siswa_id_viii !== '-' && siswa_id_viii !== '') {
                siswa_ids.push(siswa_id_viii);
            }
            if (siswa_id_ix !== '-' && siswa_id_ix !== '') {
                siswa_ids.push(siswa_id_ix);
            }

            // Cek data yang akan dikirim
            console.log('Data yang akan dikirim:', {
                _token: '{{ csrf_token() }}',
                siswa_ids: siswa_ids,
                nomor_ruangan: ruang_test
            });

            // Pastikan data siswa_ids tidak kosong
            if (siswa_ids.length === 0) {
                console.log("Tidak ada siswa yang dipilih untuk dikirim");
                return;
            }

            // Kirim data melalui AJAX
            $.ajax({
                url: '/waka-kurikulum/update-ruang-test', // Ganti dengan URL yang benar
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    siswa_ids: siswa_ids,
                    nomor_ruangan: ruang_test
                },
                success: function(response) {
                    console.log("Respon dari server:", response);
                    if (response.flash) {
                        alert(response.flash.success); // Pesan sukses
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi error:", xhr.responseText);
                    alert('Error: ' + xhr.responseJSON.error);
                }
            });
        });
    });
</script>
