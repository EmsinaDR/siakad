<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@php
    use App\Models\User;
    use App\Models\Admin\Etapel;
    use App\Models\Admin\RoleUser;
    use App\Models\User\Guru\Detailguru;
    $activecrud = collect([1, 2, 4, 6, 8])->search(Auth::user()->id);
    $etapels = Etapel::where('aktiv', 'Y')->first();

@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class='row float-right'>
                    <x-btnjs>submit/Data Role/fa fa-gear fa-spin/btn btn-primary btn-xl bg-primary
                        btn-app/CreateRole()</x-btnjs>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->

            @php
                // rolec = DB::table('role_user')->select('field');
                // $dataupdate = DB::table('role_user')->select('user_id')->where('role_id', 2)->get();
                // $dataupdate = collect($dataupdate)->flatten(1);
                // $dataupdate = $dataupdate->values()->all();
                // dd($dataupdate);
                // foreach ($dataupdate as $collectionq):
                // $hasilcoleection = implode(', ', $dataupdate); // Menangkap Array yang dikirim
                // endforeach;
                // dd($dataupdate);
                // $data_guru = App\Models\User::with('UsersDetailgurus')
                //     ->where('posisi', 'Guru')
                //     ->get()
                //     ->toarray();
                // dd($hasilcoleection);
                // $counter = collect([8, 1, 12])->search(12);
                // dd($counter);
                // dd($dataupdate);

                // dd($data_guru);
            @endphp
            <div class='ml-2'>
                <div class='card-body mr-2 ml-2'>
                    <table id='example1' width='100%' class='table table-bordered table-hover'>
                        <thead>
                            <tr class='text-center align-middle'>
                                <th width='2%'>ID</th>
                                <th width='15%'>Role</th>
                                <th width='50%'>Nama Guru</th>
                                <th width='5%'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataRole as $data)
                                <tr>
                                    <td class='text-center align-middle'>{{ $loop->iteration }}</td>
                                    <td class='text-left align-middle'>{{ $data->name }}</td>
                                    @php
                                        $roles = App\Models\Admin\RoleUser::select('user_id')
                                            ->where('role_id', $data->id)
                                            ->get()
                                            ->toarray();
                                        $roles = collect($roles)->flatten(1);
                                        $roles = $roles->values()->all();
                                    @endphp
                                    <td class='text-left'>
                                        @foreach ($roles as $role)
                                            @php
                                                $Detailguru = App\Models\User\Guru\Detailguru::where('id', $role)->get();
                                            @endphp
                                            @foreach ($Detailguru as $detailfetch)
                                                - {{ $detailfetch->nama_guru }} <br>
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (App\Models\Admin\RoleUser::where('role_id', $data->id)->count() !== 0)
                                            <div class='gap-1 d-flex justify-content-center'>
                                                <!-- Button untuk melihat -->
                                                {{-- <button type='button' class='btn btn-success btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#viewModal{{ $data->id }}'>
                                                    <i class='fa fa-eye'></i> Lihat
                                                </button> --}}
                                                <!-- Button untuk mengedit -->
                                                <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                                    data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                                    <i class='fa fa-edit'></i> Edit
                                                </button>
                                                <!-- Form untuk menghapus -->
                                                {{-- <form action='#' method='POST' style='display: inline-block;'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button typep='submit' class='btn btn-danger btn-sm btn-equal-width'
                                                        onclick="return confirm(' Apakah Anda yakin ingin menghapus data ini?');">
                                                        <i class='fa fa-trash'></i> Hapus
                                                    </button>
                                                </form> --}}
                                            </div>
                                        @else
                                        @endif
                                    </td>
                                </tr>
                                {{-- Modal View Data Akhir --}}
                                <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                    aria-labelledby='EditModalLabel' aria-hidden='true'>
                                    <x-edit-modal>
                                        <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                        <section>
                                            <form id='updateEdata{{ $loop->index }}'
                                                action='{{ route('role-guru.update', ['role_guru' => $data->id]) }}'
                                                method='POST'>
                                                @csrf
                                                @method('PATCH')
                                                {{-- {{ $data->id }} --}}
                                                @php
                                                    // Ambil user_id dari tabel role_user berdasarkan role_id tertentu
                                                    $dataupdate = DB::table('role_user')
                                                        ->where('role_id', $data->id)
                                                        ->pluck('user_id') // Ambil langsung user_id dalam bentuk array
                                                        ->toArray();
                                                    // Ambil semua data guru
                                                    $data_guru = App\Models\User\Guru\Detailguru::get();
                                                @endphp
                                                <input type='hidden' name='role_id' id='role_id'
                                                    value='{{ $data->id }}'>
                                                <div class='form-group'>
                                                    <label>Data Guru</label>
                                                    <select id='select2-{{ $loop->index }}' class='select2'
                                                        name='user_id[]' multiple='multiple'
                                                        data-placeholder='Pilih penanggung jawab' style='width: 100%;'>
                                                        <option value=''>--- Pilih judul ----</option>
                                                        @foreach ($data_guru as $user)
                                                            <option value='{{ $user->id }}'>
                                                                {{ $user->nama_guru }} - {{ $user->id }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <script>
                                                    $(document).ready(function() {
                                                        $('#select2-{{ $loop->index }} option[value="II"]').prop('selected', true); // Single Select
                                                        // $("#select2-{{ $loop->index }}").val(@json($dataupdate)).trigger("change"); // Mutiple Select Select
                                                    });
                                                </script>

                                                <button id='kirim' type='submit'
                                                    class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                                    Kirim
                                                </button>
                                            </form>
                                        </section>

                                    </x-edit-modal>
                                </div>
                                {{-- Modal Edit Data Akhir --}}
                                {{-- Modal View --}}
                                <div class='modal fade' id='viewModal' tabindex='-1' {{-- <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1' --}}
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
                            <tr class='text-center align-middle'>
                                <th width='2%'>ID</th>
                                <th width='15%'>Role</th>
                                <th width='50%'>Nama Guru</th>
                                <th width='20%'>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <script>
        function CreateRole(data) {
            var CreateRole = new bootstrap.Modal(document.getElementById('CreatRole'));
            CreateRole.show();
            // document.getElementById('Eid').value = data.id;
        }
    </script>

    {{-- Modal Edit Data Awal --}}
    <div class='modal fade' id='CreatRole' tabindex='-1' aria-labelledby='CreateRoleLabel' aria-hidden='true'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header bg-primary'>
                    <h5 class='modal-title' id='CreateRoleLabel'>
                        Create Role Guru / Karyawan / Kepala Sekolah
                    </h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='alert alert-info alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <h5><i class='icon fas fa-info'></i> Information !</h5>
                        <hr>
                        Gunakan menu ini untuk menambah di awal kali memasukkan, untuk merubah dan menghapusnya dapat
                        menggunakan menu edit yang muncul.
                    </div>

                    <form id='#id' action='' method='POST'>
                        @csrf
                        @method('POST')
                        <section>
                            <div class='form-group'>
                                <label for='kepala'>Kepala Sekolah / Madrasah</label>
                                <select name='kepala' id='kepala' class='select2 form-control'>
                                    <option value=''>--- Pilih Kepala Sekolah / Madrasah ---</option>
                                    @foreach ($user_dropdown as $newdatas)
                                        <option value='{{ $newdatas->id }}'>
                                            {{ $newdatas->UsersDetailgurus->nama_guru }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class='form-group'>
                                <label for='pembina_ekstra'>Pembina Ekstra</label>
                                <select name='pembina_ekstra[]' id='menuselecta' class='form-control'
                                    multiple='multiple' data-placeholder='Mata Pelajaran' style='width: 100%;'>
                                    <option value=''>--- Pilih Pembina Ekstra ---</option>
                                    @foreach ($user_dropdown as $dataguru)
                                        <option value='value'>{{ $dataguru->UsersDetailgurus->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class='card-header bg-primary my-2'>
                                <h3 class='card-title'>Wakil Kepala</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='waka_kurikulum'>Waka. Kurikulum</label>
                                        <select name='waka_kurikulum' class='select2 form-control'>
                                            <option value=''>--- Pilih Waka. Kurikulum ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='waka_kesiswaan'>Waka. Kesiswaan</label>
                                        <select name='waka_kesiswaan' class='select2 form-control'>
                                            <option value=''>--- Waka. Kesiswaan ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='waka_sarpras'>Waka. Sarpras</label>
                                        <select name='waka_sarpras' class='select2 form-control'>
                                            <option value=''>--- Pilih Waka. Sarpras ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='waka_humas'>Waka. Humas</label>
                                        <select name='waka_humas' class='select2 form-control'>
                                            <option value=''>--- Pilih Waka. Humas ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class='card-header bg-primary my-2'>
                                <h3 class='card-title'>Bendahara Keuangan</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='bendahara_bos'>Bendahara BOS</label>
                                        <select name='bendahara_bos' class='select2 form-control'>
                                            <option value=''>--- Pilih Bendahara BOS ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='bendahara_komite'>Bedahara Komite</label>
                                        <select name='bendahara_komite' class='select2 form-control'>
                                            <option value=''>--- Pilih Bedahara Komite ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='bendahara_study_toru'>Bendahara Study Tour</label>
                                        <select name='bendahara_study_tour' class='select2 form-control'>
                                            <option value=''>--- Pilih Bendahara Study Tour ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='bendahara_tabungan'>Bendahara Tabungan</label>
                                        <select name='bendahara_tabungan' class='select2 form-control'>
                                            <option value=''>--- Pilih Bendahara Tabungan ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='bendahara_bantuan'>Bendahara Bantuan Siswa</label>
                                        <select name='bendahara_bantuan' class='select2 form-control'>
                                            <option value=''>--- Pilih Bendahara Bantuan Siswa ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class='card-header bg-primary my-2'>
                                <h3 class='card-title'>Petugas Perputakaan</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='pembina_osis'>Pembina Osis</label>
                                        <select name='pembina_osis' class='select2 form-control'>
                                            <option value=''>--- Pilih Pembina Osis ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='petugas_perpustakaan'>Petugas Perpus</label>
                                        <select name='petugas_perpustakaan' class='select2 form-control'>
                                            <option value=''>--- Pilih Petugas Perpus ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class='form-group'>
                                        <label for='petugas_bk'>Petugas BK</label>
                                        <select name='petugas_bk' class='select2 form-control'>
                                            <option value=''>--- Pilih Petugas BK ---</option>
                                            @foreach ($user_dropdown as $newdatas)
                                                <option value='{{ $newdatas->id }}'>
                                                    {{ $newdatas->UsersDetailgurus->nama_guru }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6"></div>
                            </div> --}}
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i>
                                    Simpan</button>
                            </div>
                        </section>

                    </form>
                </div>

            </div>
        </div>

    </div>
</x-layout>
