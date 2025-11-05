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
                    <a href="{{ route('pembinaan.index') }}">
                        <button class="btn-md btn-primary btn-block">
                            <i class="fa fa-arrow-left pr-2"></i> Kembali
                        </button>
                    </a>
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
                        <form id='updateurl' action='{{ route('pembinaan.update', $data->id) }}' method='POST'>
                            @csrf
                            @method('PATCH')

                            {{-- blade-formatter-disable --}}
                            <div class='form-group'>
                                <label for='tanggal'>Tanggal</label>

                                <input type='date' class='form-control' id='tanggal' name='tanggal'
                                    placeholder='Tanggal'
                                    value='{{ Carbon::create($data->tanggal)->translatedFormat('Y-m-d') }}' required>
                            </div>
                            <div class='form-group'>
                                <label for='detailguru_id'>Nama Guru</label>
                                <select name='detailguru_id' id='id' class='select2 form-control'
                                    data-placeholder='Nama guru' disabled>
                                    <option value=''></option>
                                    @foreach ($Gurus as $Guru)
                                        <option @if ($data->detailguru_id === $Guru->id) selected @endif
                                            value='{{ $Guru->id }}'>{{ $Guru->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                                $statuss = ['Belum', 'Proses', 'Selesai'];
                            @endphp
                            <div class='form-group'>
                                <label for='status'>Status</label>
                                <select name='status' id='status' class='select2 form-control'
                                    data-placeholder='Status' required>
                                    <option value=''></option>
                                    @foreach ($statuss as $status)
                                        <option @if ($data->status === $status) selected @endif
                                            value='{{ $status }}'>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class='form-group'>
                                <i class='fas fa-sticky-note'></i><label for='indikator'>Indikator</label>
                                <textarea name='indikator' id='indikator_textarea' rows='3' class='editor form-control' placeholder='Masukkan Indikator' required>{{ old('indikator', $data->indikator) }}</textarea>
                            </div>

                            <div class='form-group'>
                                <i class='fas fa-sticky-note'></i><label for='tindak_lanjut'>Tindak Lanjut</label>
                                <textarea name='tindak_lanjut' id='tindak_lanjut' rows='3' class='editor form-control' placeholder='Masukkan Keterangan Singkat' required>{{ old('tindak_lanjut', $data->tindak_lanjut) }}</textarea>
                            </div>

                            <div class='form-group'>
                                <i class='fas fa-sticky-note'></i><label for='kesimpulan_umum'>Kesimpulan</label>
                                <textarea name='kesimpulan_umum' id='kesimpulan_umum' rows='4' class='editor form-control' placeholder='Masukkan Keterangan Singkat' required>{{ old('kesimpulan_umum', $data->kesimpulan_umum) }}</textarea>
                            </div>


                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i>
                                    Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
