@php
    use App\Models\User;

    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    use App\Models\User\Siswa\Detailsiswa;
    // use App\Models\User;
    $activecrud = collect([2, 3, 6, 8])->search(Auth::user()->id);

@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <div class='card'>
            <div class="card-body">
                <div class='row float-right'>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='card-body mr-2 ml-2'>
                <table id='example1' width='100%' class='table table-responsive table-bordered table-hover'>
                    <thead>
                        <tr class='text-center'>
                            <th width='1%'>ID</th>
                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach

                            @if ($activecrud === 1)
                                <th width='20%'>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userKaryawan as $data)
                            <tr>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td>{{ $data->UsersDetailgurus->namaguru }} ({{ $data->name }})</td>
                                <td class='text-center'>{{ $data->UsersDetailgurus->status }}</td>
                                <td>{{ $data->UsersDetailgurus->pendidikan }} - {{ $data->UsersDetailgurus->jurusan }}
                                </td>
                                <td class='text-center'>{{ $data->UsersDetailgurus->jenis_kelamin }}</td>
                                @if ($activecrud === 1)
                                    {{-- @if ($activecrud === 1 and Auth::user()->id === (int) $data->user_id) --}}
                                    <td>
                                        <button type='button' class='btn btn-default bg-success btn-sm'
                                            onclick="ViewModal({{ $data }}, {{ $data['id'] }})"><i
                                                class='fa fa-eye right'> </i> Lihat</button>
                                        <button class="btn btn-warning btn-sm"
                                            onclick="EditModal({{ $data }}, {{ $data['id'] }})"><i
                                                class='fa fa-edit right'></i> Edit</button>
                                        <button type='submit' class='btn  btn-default bg-danger btn-sm'><i
                                                class='fa fa-trash'></i> Hapus</button>
                                    </td>
                                @elseif($activecrud === 1 and Auth::user()->id != (int) $data->user_id)
                                    <td></td>
                                @else
                                @endif
                                {{-- @endforeach --}}

                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='text-center'>

                            <th width='1%'>ID</th>

                            @foreach ($arr_ths as $arr_th)
                                <th class='text-center'> {{ $arr_th }}</th>
                            @endforeach

                            @if ($activecrud === 1)
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
