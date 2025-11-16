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

                        <table id='example1' width='100%' class='table table-bordered table-hover'>
                            <thead>
                                <tr>
                                    <th class='text-center align-middle'>No</th>
                                    <th class='text-center align-middle'>ID Petugas</th>
                                    <th class='text-center align-middle'>Nama Petugas</th>
                                    <th class='text-center align-middle'>Jadwal Pelaksanaan</th>
                                    <th class='text-center align-middle'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($petugasIds as $i => $id)
                                    <tr>
                                        <td class='text-center align-middle'>{{ $i + 1 }}</td>
                                        <td class='text-center align-middle'>{{ $id }}</td>
                                        <td class='text-center align-middle'> {{ $petugas[$id]->nama_guru ?? 'Tidak ditemukan' }}</td>
@php
$JadwalPerpus = \App\Models\Program\Supervisi\Jadwal\JadwalSupervisiPerpustakaan::where('tapel_id', $Tapels->id)->where('petugas_id', $id)->first();
@endphp

<td class='text-center align-middle'>
    {{ $JadwalPerpus?->tanggal_pelaksanaan
        ? \Carbon\Carbon::parse($JadwalPerpus->tanggal_pelaksanaan)->translatedFormat('l, d F Y')
        : 'Belum dijadwalkan' }}
</td>




                                        <td class="text-center align-middle">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#editModal{{ $id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Tombol Delete -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteModal{{ $id }}" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>

                                        <div class="modal fade" id="editModal{{ $id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="editModalLabel{{ $id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <form
                                                        action="{{ $id ? route('jadwal-supervisi-perpustakaan.store', $id) : route('jadwal-supervisi-perpustakaan.store') }}"
                                                        method="POST">
                                                        @csrf


                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editModalLabel{{ $id ? $id : 'new' }}">
                                                                {{ $id ? 'Edit Petugas' : 'Buat Petugas' }}
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="petugas_id"
                                                            value="{{ $id }}">

                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="nama_guru">Nama Petugas</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_guru" name="nama_guru"
                                                                    value="{{ old('nama_guru', $petugas[$id]->nama_guru ?? '') }}"
                                                                    required>
                                                            </div>

                                                            <!-- Input Tanggal Pelaksanaan -->
                                                            <div class="form-group">
                                                                <label for="tanggal_pelaksanaan">Tanggal
                                                                    Pelaksanaan</label>
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_pelaksanaan" name="tanggal_pelaksanaan"
                                                                    value="{{ old('tanggal_pelaksanaan', $petugas[$id]->tanggal_pelaksanaan ?? '') }}"
                                                                    required>
                                                            </div>

                                                            <!-- Input lainnya jika dibutuhkan -->
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                {{ $id ? 'Update' : 'Simpan' }}
                                                            </button>
                                                        </div>
                                                    </form>


                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
