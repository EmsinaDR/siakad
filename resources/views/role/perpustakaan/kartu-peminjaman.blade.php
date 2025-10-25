@php
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
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary
                        btn-app/namaModal()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            <style>
                td {
                    height: 40px;
                }
            </style>

            <div class='ml-2 my-4'>
                <div class="row gap-2">
                    @foreach ($datas as $data)
                        <div class="col-xl-6 p-3">
                            <div class="card">
                                <div class='card-header bg-primary'>
                                    <h3 class='card-title'>Kartu Peminjaman Buku - {{ $data->nama_siswa }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row p-2">
                                        <div class="col-xl-4">
                                            <img src='{{ app('request')->root() }}/img/logo.png' alt='' style='width:auto;height:auto;'>
                                        </div>
                                        <div class="col-xl-8 mt-4">
                                            <div class="row">
                                                <div class="col-xl-4">
                                                    <p><strong>Nama</strong></p>
                                                    <p><strong>NIS</strong></p>
                                                    <p><strong>NISN</strong></p>
                                                    <p><strong>Kelas</strong></p>
                                                </div>
                                                <div class="col-xl-8">
                                                    <p>: {{ $data->nama_siswa }}</p>
                                                    <p>: {{ $data->nis }}</p>
                                                    <p>: {{ $data->nisn }}</p>
                                                    <p>: {{ $data->DetailsiswatoKelas->kelas }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table width='100%' class='table table-bordered table-hover p-2'>
                                        <thead>
                                            <tr class='text-center align-middle table-primary'>
                                                <th class='text-center align-middle' width='60%'>Judul Buku</th>
                                                <th class='text-center align-middle'>Tanggal Pinjam</th>
                                                <th class='text-center align-middle'>Tanggal Kembali</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < 15; $i++)
                                                <tr>
                                                    <td class='text-center'></td>
                                                    <td class='text-center'></td>
                                                    <td class='text-center'></td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                        <tfoot>
                                            <tr class='text-center align-middle table-primary'>
                                                <th>Judul Buku</th>
                                                <th>Tanggal Pinjam</th>
                                                <th>Tanggal Kembali</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='FNnamaModal()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function namaModal(data) {
        var namaModal = new bootstrap.Modal(document.getElementById('namaModal'));
        namaModal.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='namaModal' tabindex='-1' aria-labelledby='LabelnamaModal' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelnamaModal'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>
