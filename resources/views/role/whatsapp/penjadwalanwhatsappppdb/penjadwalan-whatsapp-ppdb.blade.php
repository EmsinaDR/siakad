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

        /* .btn-equal-width {
            min-width: 40px !important;
            /* atau 50px, bebas sesuai kebutuhan */
            text-align: center;
            display: inline-flex;
            justify-content: center;
            align-items: center;
        } */
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
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#tambahData'><i class='fa fa-plus'></i> Tambah Jadwal</button>
                </div>
                {{-- blade-formatter-enable --}}
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        {{-- Catatan :
                        - Include Komponen Modal CRUD + Javascript / Jquery
                        - Perbaiki Onclick Tombol Modal Create, Edit
                        - Variabel Active Crud menggunakan ID User
                         --}}
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
                                @foreach ($PenjadwalanWhatsappPPDB as $data)
                                    <tr>
                                        <td class='text-center'>{{ $loop->iteration }}</td>
                                        <td class='text-center'> {{ $data->judul ?? ''}}</td>
                                        <td class='text-center'> {{ $data->status ?? '' }}</td>
                                        <td class='text-center'>{{ Carbon::create($data->scheduled_at)->translatedformat('l, d F Y') }} -  {{ Carbon::create($data->scheduled_at)->translatedformat('H:i') }}</td>

                                        <td width='10%'>
                                            {{-- blade-formatter-disable --}}
                                                   <div class='d-flex justify-content-center gap-1'>
                                                       <!-- Button untuk mengedit -->
                                                       <a href="{{ route('penjadwalan.edit', $data->id) }}" class="btn btn-warning btn-sm btn-equal-width" data-toggle="modal" data-target="#editModal{{ $data->id }}"><i class="fa fa-edit"></i></a>

                                                       <!-- Form untuk menghapus -->
                                                       <form id='delete-form-{{ $data->id }}' action='{{ route('penjadwalan.destroy', $data->id) }}' method='POST' style='display: inline-block;'>
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
                                                            action='{{ route('penjadwalan.update', $data->id) }}'
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


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='tambahData' tabindex='-1' aria-labelledby='LabeltambahData' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h4 class="mb-0">📤 Buat Jadwal WA</h4>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <form action="{{ route('penjadwalan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <div class='form-group'>
                           <label for='judul'>Judul</label>
                           <input type='text' class='form-control' id='judul' name='judul' placeholder='Judul sebagai pengingat' required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tipe_tujuan" class="form-label fw-bold">Tipe Tujuan</label>
                        <select name="tipe_tujuan" id="tipe_tujuan" class="select2 form-select" onchange="toggleTujuan()">
                            <option value="nomor">Manual (Nomor HP)</option>
                            <option value="guru">Guru</option>
                            <option value="kelas">Kelas</option>
                            <option value="siswa">Pilih Siswa Tertentu</option>
                        </select>
                    </div>

                    <div class="mb-3" id="field_nomor">
                        <label for="tujuan" class="form-label fw-bold">Nomor WhatsApp</label>
                        <input type="text" name="tujuan" id="tujuan" class="form-control" value='6289532960005' placeholder="6281234567890">
                    </div>

                    <div class="mb-3 d-none" id="field_kelas">
                        <label for="tujuan_kelas" class="form-label fw-bold">Pilih Kelas</label>
                        <select name="tujuan_kelas[]" id="tujuan_kelas" class="select2 form-select">
                            @foreach ($Kelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="field_siswa">
                        <label for="tujuan_siswa" class="form-label fw-bold">Pilih Siswa</label>
                        <select name="tujuan_siswa[]" id="tujuan_siswa" class="select2 form-select" multiple>
                            @foreach ($Siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama_siswa }} -
                                    {{ $siswa->nohp_siswa }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Gunakan Ctrl (Windows) / Cmd (Mac) untuk pilih lebih dari
                            satu.</small>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 mb-3">
                            <label for="tanggal" class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                        </div>
                        <script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>

                        <div class="col-xl-6 mb-3">
                            <label for="jam" class="form-label fw-bold">Jam</label>
                            <input type="time" name="jam" id="jam" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="pesan_wa" class="form-label">Pesan WhatsApp</label>
                        <textarea id="editorwa" name="pesan" class=" form-control" rows="6"></textarea>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            tinymce.remove(); // Optional kalau sudah pernah inisialisasi sebelumnya
                            tinymce.init({
                                selector: '#editorwa',
                                menubar: false,
                                plugins: 'link lists',
                                toolbar: 'undo redo | bold italic underline | bullist numlist | link',
                                height: 250,
                                branding: false
                            });
                        });
                    </script>

                    <button type="submit" class="float-right btn btn-success">
                        💾 Simpan Jadwal
                    </button>
                </form>

                <script>
                    function toggleTujuan() {
                        const tipe = document.getElementById('tipe_tujuan').value;
                        document.getElementById('field_nomor').classList.toggle('d-none', tipe !== 'nomor');
                        document.getElementById('field_kelas').classList.toggle('d-none', tipe !== 'kelas');
                        document.getElementById('field_siswa').classList.toggle('d-none', tipe !== 'siswa');
                    }
                    document.addEventListener('DOMContentLoaded', toggleTujuan);
                </script>


            </div>
        </div>

    </div>
