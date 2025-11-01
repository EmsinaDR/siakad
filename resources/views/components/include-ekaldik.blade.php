@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Number;

    use App\Models\Admin\Etapel;
    use App\Models\Role;
    use App\Models\User;

    use App\Models\ekaldik;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    // dd($datas);
    // dd(is_int(Auth::user()->id));
    // dd(is_int(Auth::user()->id));

    // $user =User::with('role')->find(3);
    // $users = DB::table('users')
    // ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')

    // ->where('id', 3)->get();
    // foreach($users as $user['name']):

    // $userq[] = $user;
    // endforeach;

    // dd($userq);

    // $users = DB::table('users')
    // ->join('contacts', 'users.id', '=', 'contacts.user_id')
    // ->join('orders', 'users.id', '=', 'orders.user_id')
    // ->select('users.*', 'contacts.phone', 'orders.price')
    // ->get();

    // $userx = Role::get();

    // $user = User::with('roles')->get();

    // $users = DB::table('users');

    // $users = DB::table('roles')
    // ->leftJoin('users', 'users.id', '=', 'roles.user_id')
    // ->get();

    // $users = DB::table('users')
    // ->leftJoin('roles', 'users.id', '=', 'roles.user_id')
    // ->get();

    // dd($user);

    // dd(Auth::user()->id);

    $activecrud = collect([1, 2, 4, 6, 8])->contains(Auth::user()->id);

    // dd($activecrud );

@endphp


<div class='card'>
    {{-- Papan Informasi --}}
    {{-- Papan Informasi --}}

    <div class='card p-2'>
        <!--Car Header-->
        <div class='card-header bg-primary mx-2'>
            <h3 class='card-title'>{{ $title }}</H3>
        </div>
        <!--Car Header-->
@php
$cek = $Programs->where('nama_program', 'Kaldik')->first();
$datax = in_array(Auth::user()->detailguru_id, json_decode($cek->detailguru_id, true));
// dump($datax);
@endphp

        @if ($datax === true)
            <div class="row p-2">
                <div class="col-xl-2">
                    <button type='button' onclick="CreateModal()" class='btn btn-block bg-primary btn-md'><i
                            class="fa fa-plus-square"></i> Tambah</button>
                </div>
                <div class="col-xl-10"></div>
            </div>
        @endif


        <div class='card-body mr-2 ml-2'>
            <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                <thead>
                    <tr class='text-center table-primary align-middle'>
                        <th width='1%'>ID</th>
                        @foreach ($arr_ths as $arr_th)
                            <th> {{ $arr_th }}</th>
                        @endforeach
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td class='text-center align-middle'>{{ $loop->iteration }}</td>

                            <td> {{ $data->kegiatan }}</td>
                            <td class='text-center align-middle'> Rp.
                                {{ Number::format($data->rencana_anggaran, precision: 2) }}</td>
                            @php
                                $id_guru = explode(',', $data['penanggung_jawab']);
                            @endphp
                            <td class='text-center align-middle'>
                                {{-- blade-formatter-disable --}}
                                @foreach ($id_guru as $guid)
                                    @php
                                        $datanews = App\Models\User\Guru\Detailguru::where('id', $guid)->get();
                                    @endphp
                                    @foreach ($datanews as $datanew)
                                        <button type='button' class='btn btn-default bg-primary btn-sm pill-2'>{{ $datanew['nama_guru'] }}</button>
                                    @endforeach
                                @endforeach
                                {{-- blade-formatter-enable --}}
                            </td>
                            <td class='text-center align-middle'>
                                {{ Carbon::create($data->created_at)->translatedformat('l, d F Y') }} </td>

                            @if ($activecrud === true and Auth::user()->id === $data->detailguru_id)
                                <td>
                                    <div class='gap-1 d-flex justify-content-center'>
                                        <!-- Button untuk mengedit -->
                                        <button type='button' class='btn btn-warning btn-sm btn-equal-width'
                                            data-toggle='modal' data-target='#editModal{{ $data->id }}'>
                                            <i class='fa fa-edit'></i>
                                        </button>
                                        <!-- Form untuk menghapus -->
                                        <form id='delete-form-{{ $data->id }}'
                                            action='{{ route('ekaldik.destroy', $data->id) }}' method='POST'
                                            style='display: inline-block;'>
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button type='button' class='btn btn-danger btn-sm btn-equal-width'
                                            onclick='confirmDelete({{ $data->id }})'> <i class='fa fa-trash'></i>
                                        </button>
                                    </div>
                                </td>
                        </tr>
                        {{-- Modal View Data Akhir --}}
                        <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                            aria-labelledby='EditModalLabel' aria-hidden='true'>
                            <x-edit-modal>
                                <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                <section>
                                    <form id='updateEdata' action='{{ route('ekaldik.update', $data->id) }}'
                                        method='POST'>
                                        @csrf
                                        @method('PATCH')

                                        <section>
                                            {{-- blade-formatter-disable --}}
                                            <input type='hidden' class='form-control' id='ctapel_id' name='tapel_id' value='{{ App\Models\Admin\Etapel::where('aktiv', 'Y')->first()->id }}' required>
                                            <input type='hidden' class='form-control' id='detailguru_id' name='detailguru_id' placeholder='Kegiatan' value='{{ Auth::user()->id }}'>
                                            <div class='form-group'>
                                                <label for='ckategori'>Kategori</label>
                                                <input type='text' class='form-control' id='ckategori' name='kategori' placeholder='Kategori' value='{{$data->kategori}}' required>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class='form-group'>
                                                        <label for='ctgl_awal'>Tanggal Awal</label>
                                                        {{-- {{dump($data)}} --}}

                                                        <input type='date' class='form-control' id='ctgl_awal' name='tgl_awal'  placeholder='Tanggal Awal Pelaksanaan' value='{{ \Carbon\Carbon::parse($data->tgl_awal)->format('Y-m-d') }}' required>
                                                        {{-- <input type="datetime-local" name="tanggal" value="{{ \Carbon\Carbon::parse($data->tgl_awal)->format('Y-m-d\TH:i') }}"> --}}

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class='form-group'>
                                                        <label for='ctgl_akhir'>Tanggal Akhir</label>
                                                        <input type='date' class='form-control' id='ctgl_akhir' name='tgl_akhir'  placeholder='Tanggal Akhir Pelaksanaan' value='{{ \Carbon\Carbon::parse($data->tgl_akhir)->format('Y-m-d') }}' required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label for='ckegiatan'>Kegiatan</label>
                                                <input type='text' class='form-control' id='ckegiatan' rows="3" name='kegiatan'  placeholder='Kegiatan yang akan dilaksanakan' value='{{$data->kegiatan}}' required>
                                            </div>
                                            <div class='form-group'>
                                                <label for='ctujuan'>Tujuan</label>
                                                <input type='text' class='form-control' id='ctujuan' name='tujuan'placeholder='Tujuan pelaksanaan pada kegiatan' value='{{$data->tujuan}}' required>
                                            </div>
                                            <div class='form-group'>
                                                <label for='cindikator_pecapaian'>Indikator Pencapaian</label>
                                                <textarea type='text' class='form-control ' rows="3" id='cindikator_pecapaian' name='indikator_pecapaian' placeholder='Indikator pencapaian pada kegiatan' required>{{$data->indikator_pecapaian}}</textarea>

                                            </div>
                                            <div class='form-group'>
                                                <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                                                @php
                                                // $DataUpdate = explode(',', $data->penanggung_jawab);
                                                $DataUpdate = $data->penanggung_jawab;
                                                @endphp
                                                <label>Penanggung Jawab {{$DataUpdate}}</label>
                                                <select id='select2_{{ $data->id }}' class='form-control' name='penanggung_jawab' data-placeholder='Data guru sebagain penanggung jawab' style='width: 100%;'>
                                                    <option value=''>--- Pilih Penanggung Jawab ----</option>
                                                    @foreach ($users as $user)
                                                        <option value='{{ $user->id }}'>{{ $user->nama_guru }}</option>
                                                    @endforeach

                                                </select>
                                                <script>
                                                   $(document).ready(function() {
                                                       // $('#semesteredit option[value='II']').prop('selected', true); // Single Select
                                                       $('#select2_{{ $data->id }}').val(@json($DataUpdate)).trigger('change'); // Mutiple Select Select value in array json
                                                   });
                                                </script>

                                            </div>
                                            <div class='form-group'>
                                                <label for='crencana_anggaran'>Rencana Anggaran</label>
                                                <input type='text' class='form-control' id='crencana_anggaran' name='rencana_anggaran' pattern="^\Rp. \d{1,3}(,\d{3})*(\.\d+)?Rp. " value='{{$data->rencana_anggaran}}'  data-type="currency" placeholder='Rp. 25.0000'>
                                            </div>
                                            {{-- blade-formatter-enable --}}
                                        </section>
                                        <button id='kirim' type='submit'
                                            class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>


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
                    @elseif($activecrud === 1 and Auth::user()->id != (int) $data->user_id)
                        <td></td>
                    @else
                        <td></td>
                    @endif

                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width='1%'>ID</th>

                        @foreach ($arr_ths as $arr_th)
                            <th> {{ $arr_th }}</th>
                        @endforeach
                        @if ($activecrud === true)
                            <th>Action</th>
                        @endif

                    </tr>
                </tfoot>
            </table>


        </div>


    </div>
    {{-- Modal Awal Tempale --}}
    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
    <x-slot:titlecreateModal>{{ $titlecreateModal }}</x-slot:titlecreateModal>
    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
    <script>
        function CreateModal(data) {
            var CreateteModal = new bootstrap.Modal(document.getElementById('createModal'));
            CreateteModal.show();
            document.getElementById('ctapel_id').value = data.tapel_id;

        }
    </script>

    {{-- Modal Create Data Awal --}}
    <div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='CreateModalLabel' aria-hidden='true'>
        <x-create-modal>
            <form id='#id' action='{{ route('ekaldik.store') }}' method='POST'>
                {{-- {{ dd($tapele['id']) }} --}}
                @csrf
                <x-slot:titlecreateModal>{{ $titlecreateModal }}</x-slot:titlecreateModal>
                <section>
                    {{-- blade-formatter-disable --}}
                    <input type='hidden' class='form-control' id='ctapel_id' name='tapel_id' value='{{ App\Models\Admin\Etapel::where('aktiv', 'Y')->first()->id }}' required>
                    <input type='hidden' class='form-control' id='detailguru_id' name='detailguru_id' placeholder='Kegiatan' value='{{ Auth::user()->id }}'>
                    <div class='form-group'>
                        <label for='ckategori'>Kategori</label>
                        <input type='text' class='form-control' id='ckategori' name='kategori' placeholder='Kategori'  required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class='form-group'>
                                <label for='ctgl_awal'>Tanggal Awal</label>
                                <input type='date' class='form-control' id='ctgl_awal' name='tgl_awal'  placeholder='Tanggal Awal Pelaksanaan' required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class='form-group'>
                                <label for='ctgl_akhir'>Tanggal Akhir</label>
                                <input type='date' class='form-control' id='ctgl_akhir' name='tgl_akhir'  placeholder='Tanggal Akhir Pelaksanaan' required>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='ckegiatan'>Kegiatan</label>
                        <input type='text' class='form-control' id='ckegiatan' rows="3" name='kegiatan'  placeholder='Kegiatan yang akan dilaksanakan' required>
                    </div>
                    <div class='form-group'>
                        <label for='ctujuan'>Tujuan</label>
                        <input type='text' class='form-control' id='ctujuan' name='tujuan'placeholder='Tujuan pelaksanaan pada kegiatan' required>
                    </div>
                    <div class='form-group'>
                        <label for='cindikator_pecapaian'>Indikator Pencapaian</label>
                        <textarea type='text' class='form-control ' rows="3" id='cindikator_pecapaian' name='indikator_pecapaian' placeholder='Indikator pencapaian pada kegiatan' required></textarea>

                    </div>
                    <div class='form-group'>
                        <!-- Jika menggunakan multiple select2 tambahkan id dengan id berbeda -->
                        <label>Penanggung Jawab X</label>
                        <select id='select2' class='form-controll' name='penanggung_jawab[]' multiple='multiple'  data-placeholder='Data guru sebagain penanggung jawab' style='width: 100%;'>
                            <option value=''>--- Pilih Penanggung Jawab ----</option>
                            @foreach ($users as $user)
                                <option value='{{ $user['id'] }}'>{{ $user['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='form-group'>
                        <label for='crencana_anggaran'>Rencana Anggaran</label>
                        <input type='text' class='form-control' id='crencana_anggaran' name='rencana_anggaran' pattern="^\Rp. \d{1,3}(,\d{3})*(\.\d+)?Rp. " value='' data-type="currency" placeholder='Rp. 25.0000'>
                    </div>
                    {{-- blade-formatter-enable --}}
                </section>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>

                </div>
            </form>


        </x-create-modal>

    </div>
    {{-- Modal Create Data Akhir --}}
