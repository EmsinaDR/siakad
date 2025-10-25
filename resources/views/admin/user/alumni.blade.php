@php
    use App\Models\User;
    use App\Models\User\Siswa\Detailsiswa;

    $activecrud = collect([1, 2, 4, 6, 8])->search(Auth::user()->id);
@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>


    <section class='content mx-2'>
        <div class='card'>
            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->
            <div class='card-body mr-2 ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'></tr>

                        <th class='text-center' width='1%'>ID</th>

                        @foreach ($arr_ths as $arr_th)
                            <th class='text-center'> {{ $arr_th }}</th>
                        @endforeach
                        @if ($activecrud === 0 or $activecrud === 1)
                            {{-- {{ Auth::user()->id }} --}}
                            <th class='text-center'>Action</th>
                        @endif
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($alumni_data) --}}
                        @foreach ($alumni_data as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }} </td>
                                <td>{{ $data->UsersDetailsiswa->tahun_lulus ?? '' }}</td>
                                <td>{{ $data->UsersDetailsiswa->nama_siswa ?? '' }}</td>
                                <td class='text-center'>{{ $data->UsersDetailsiswa->nis ?? '' }}</td>
                                <td class='text-center'>{{ $data->UsersDetailsiswa->jengkel ?? '' }}</td>
                                @if ($activecrud === 0 or $activecrud === 1)
                                    {{-- siswa
                            datay --}}
                                    <td width="10%">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Tombol Lihat -->
                                            <button type="button" class="btn btn-sm btn-success px-2 py-1"
                                                data-toggle="modal" data-target="#viewModal{{ $data->id }}"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa fa-eye"></i>
                                            </button>

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-sm btn-warning px-2 py-1"
                                                data-toggle="modal" data-target="#editModal{{ $data->id }}"
                                                style="width: 32px; height: 32px;">
                                                <i class="fa fa-edit"></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('siswa.destroy', $data->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger px-2 py-1"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus tugas ini?');"
                                                    style="width: 32px; height: 32px;">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>


                            </tr>
                            {{-- Modal View Data Akhir --}}
                            <div class='modal fade' id='editModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='EditModalLabel' aria-hidden='true'>
                                <x-edit-modal-xl>
                                    <x-slot:ukuran>lg</x-slot:ukuran>
                                    <x-slot:titleeditModal>{{ $titleeditModal }}</x-slot:titleeditModal>
                                    <section>
                                        <form id='update' action='{{ route('siswa.update', $data->id) }}'
                                            method='POST'>
                                            @csrf
                                            @method('POST')
                                            {{-- blade-formatter-disable --}}

                                        <section>
                                                <x-inputallin>:Nama Siswa::nama_siswa:id_nama_siswa:{{ $data->nama_siswa ?? ''  }}:Required</x-inputallin>
                                                <div class="row mt-2">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:NIS::nis:id_nis:{{ $data->nis ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:NISN::nisn:id_nisn:{{ $data->nisn ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:NIK::nik:id_nik:{{ $data->nik ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <x-inputallin>:Alamat Siswa::alamat:id_nama_siswa:{{ $data->nama_siswa ?? ''  }}:Required</x-inputallin>
                                                <div class="row">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Tahun Masuk::tahun_masuk:id_tahun_masuk:{{ $data->tahun_masuk ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Tahun Lulus::tahun_lulus:id_tahun_lulus:{{ $data->tahun_lulus ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Agama::agama:id_agama:{{ $data->agama ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Status Anak::status_anak:id_status_anak:{{ $data->status_anak ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Jumlah Saudara::jml_saudara:id_jml_saudara:{{ $data->jml_saudara ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Anak Ke::anakke:id_anakke:{{ $data->anakke ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Jenis Kelamin::jengkel:id_jengkel:{{ $data->jengkel ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>type:Tempat Lahir::tmpt_lahir:id_tmpt_lahir:{{ $data->tmpt_lahir ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>date:Tanggal Lahir::tgl_lahir:tgl_lahir:{{ $data->tgl_lahir ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Hobi::hobi:id_hobi:{{ $data->hobi ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Cita Cita::cita_cita:id_cita_cita:{{ $data->cita_cita ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:No HP Siswa::nohp_siswa:id_nohp_siswa:{{ $data->nohp_siswa ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>

                                                <div class='card-header bg-primary mt-2'>
                                                    <h3 class='card-title'>Pengaturan Kelas</h3>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-4">
                                                        <x-inputallin>:Jabatan Kelas::jabatan_kelas:id_jabatan_kelas:{{ $data->jabatan_kelas ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>type:Piket Kelas::piket:id_piket:{{ $data->piket ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-4">
                                                        <x-inputallin>type:Petugas Upacara::petugas_upacara:id_petugas_upacara:{{ $data->petugas_upacara ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <x-inputallin>type:Alamat Siswa::alamat_siswa:id_alamat_siswa:{{ $data->alamat_siswa ?? ''  }}:Required</x-inputallin>
                                                <div class='card-header bg-primary mt-2'>
                                                    <h3 class='card-title'>Data Sekolah Asal</h3>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-6">
                                                        <x-inputallin>type:Sekolah Asal::namasek_asal:id_namasek_asal:{{ $data->namasek_asal ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-6">
                                                        <x-inputallin>type:Alamat Sekolah Asal::alamatsek_asal:id_alamatsek_asal:{{ $data->alamatsek_asal ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-6 p-2">
                                                        <div class='card-header bg-primary mb-2'>
                                                            <h3 class='card-title'>Data Ayah</h3>
                                                        </div>
                                                        <x-inputallin>type:Nama Ayah::nama_ayah:id_nama_ayah:{{ $data->nama_ayah ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Pekerjaan::pekerjaan_ayah:id_pekerjaan_ayah:{{ $data->pekerjaan_ayah ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Penghasilam::penghasilan_ayah:id_penghasilan_ayah:{{ $data->penghasilan_ayah ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:No HP::nohp_ayah:id_nohp_ayah:{{ $data->nohp_ayah ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Alamat::alamat_ayah:id_alamat_ayah:{{ $data->alamat_ayah ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                    <div class="col-xl-6 p-2">
                                                        <div class='card-header bg-primary mb-2'>
                                                            <h3 class='card-title'>Data Ibu</h3>
                                                        </div>
                                                        <x-inputallin>type:Nama Ibu::nama_ibu:id_nama_ibu:{{ $data->nama_ibu ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Pekerjaan::pekerjaan_ibu:id_pekerjaan_ibu:{{ $data->pekerjaan_ibu ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Penghasilam::penghasilan_ibu:id_penghasilan_ibu:{{ $data->penghasilan_ibu ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:No HP::nohp_ibu:id_nohp_ibu:{{ $data->nohp_ibu ?? ''  }}:Required</x-inputallin>
                                                        <x-inputallin>type:Alamat::alamat_ibu:id_alamat_ibu:{{ $data->alamat_ibu ?? ''  }}:Required</x-inputallin>
                                                    </div>
                                                </div>
                                                <button id='kirim' type='submit' class='btn float-right btn-default bg-primary btn-xl mt-4'> Kirim</button>
                                        </section>
                                        {{-- blade-formatter-enable --}}

                                        </form>
                                    </section>

                                </x-edit-modal-xl>
                            </div>
                            {{-- Modal Edit Data Akhir --}}
                            {{-- Modal View --}}
                            <div class='modal fade' id='viewModal{{ $data->id }}' tabindex='-1'
                                aria-labelledby='ViewModalLabel' aria-hidden='true'>

                                <x-view-modal>
                                    <x-slot:titleviewModal>{{ $titleviewModal }}</x-slot:titleviewModal>
                                    <section>
                                        <section>

                                            </form>
                                        </section>

                                    </section>
                                </x-view-modal>
                            </div>
                            {{-- Modal View Akhir --}}
                        @elseif($activecrud === 1 and Auth::user()->id != (int) $data->user_id)
                            <td></td>
                        @else
                        @endif
                        @endforeach

                        </tr>

                        {{-- @endforeach --}}

                    </tbody>
                    <tfoot>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>

                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach
                            @if ($activecrud === 0 or $activecrud === 1)
                                <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
        </div>
    </section>

</x-layout>
{{-- {{ JavaScript Awal Modal}} --}}
<script>
    function CreateModal(data) {
        // Show Modal Create Data
        var CreateteModal = new bootstrap.Modal(document.getElementById('createModal'));
        CreateteModal.show();
        // Kirim Nilai Ke Modal byID
        document.getElementById('ctapel_id').value = data.tapel_id;
    }
</script>
{{-- {{ JavaScript Modal Akhir }} --}}

{{-- Modal Create Data Awal --}}
{{-- blade-formatter-disable --}}
<div class='modal fade' id='createModal' tabindex='-1' aria-labelledby='CreateModalLabel' aria-hidden='true'>
    <x-create-modal>
        <form id='#id' action='{{ route('siswa.store') }}' method='POST'>
            @csrf
            <x-slot:titlecreateModal>{{ $titlecreateModal }}</x-slot:titlecreateModal>
            <section>
                <x-inputs>Id:id/Status_Siswa:status_siswa/Foto:foto/Nama_Siswa:nama_siswa/Nis:nis/Nisn:nisn/Nik:nik/Hobi:hobi</x-inputs>
                <div class='card-header bg-primary'>
                    <h3 class='card-title'>Data Sekolah</h3>
                </div>
                <x-inputs>Jabatan_Kelas:jabatan_kelas/Petugas_Upacara:petugas_upacara/Namasek_Asal:namasek_asal/Alamatsek_Asal:alamatsek_asal/Nama_Ayah:nama_ayah/Pekerjaan_Ayah:pekerjaan_ayah/Penghasilan_Ayah:penghasilan_ayah/Nohp_Ayah:nohp_ayah</x-inputs>
            </section>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </form>
    </x-create-modal>
</div>

{{-- blade-formatter-enable --}}
