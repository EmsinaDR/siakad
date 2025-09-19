@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $cocardroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }

        .card-title {
            text-align: left !important;
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
                {{-- blade-formatter-disable --}}
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#CreateCocard'><i class='fa fa-plus'></i> Buat Cocard Guru</button>
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
                        <div class="row">
                            @foreach ($Cocard as $data)
                                <div class="col-md-3 mb-4 text-center">
                                    <div class="card h-100 shadow-sm">
                                        <h3 class="mb-1 text-center"><b>{{ $data->nama }}</b></h3>
                                        <table>
                                            <tr>
                                                <td class='text-left'>Kode</td>
                                                <td class='text-left'>: {{ $data->kode }}</td>
                                            </tr>
                                            <tr>
                                                <td class='text-left'>Keterangan</td>
                                                <td class='text-left'>: {{ $data->keterangan }}</td>
                                            </tr>
                                        </table>
                                        {{-- <img src="{{ asset('img/template/cocard/' . $data->kode . '.svg') }}" class="card-img-top" alt="{{ $data->nama }}"> --}}
                                        <img src="{{ render_svg_base64($data->kode, [
                                            'line2' => 'Kelas',
                                            'posisi' => 'PESERTA',
                                            'nama' => 'Dany Rosepta',
                                            'nip' => '-',
                                            'namasekolah' => strtoupper($Identitas->namasek),
                                            'namakegiatan' => 'UJIAN MADRASAH',
                                            'foto' => 'img/template/cocard/property/blank.png',
                                            'logosekolah' => 'img/logo.png',
                                            'logodinas' => 'img/logo/kemenag.png',
                                            'tapel' => date('Y') . '/' . date('Y') + 1,
                                        ]) }}"
                                            class="card-img-top" alt="alt nama">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>


{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='CreateCocard' tabindex='-1' aria-labelledby='LabelCreateCocard' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelCreateCocard'>
                    Buat Co Card
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                @php
                $Perans =['Panitia', 'Peserta'];
                @endphp

                <form id='CreateCocard-form' action='{{ route('cocard.generate') }}' method='POST'>
                    @csrf
                    @method('POST')
                    <div class='form-group'>
                       <label for='judul'>Judul</label>
                       <input type='text' class='form-control' id='judul' name='judul' placeholder='Tuliskan judul Contoh : Ujian Madrasah' required>
                    </div>
                    <div class='form-group'>
                       <label for='peran'>Peran</label>
                       <select name='peran' id='peran' data-placeholder='Pilih Data Peran' class='select2 form-control' required>
                               <option value=''>--- Pilih Peran ---</option>
                           @foreach($Perans as $newPerans)
                               <option value='{{$newPerans}}'>{{$newPerans}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                       <label for='detailguru_id'>Nama Guru</label>
                       <select name='detailguru_id[]' id='detailguru_id' multiple data-placeholder='Pilih Data Nama Guru' class='select2 form-control' required>
                           @foreach($Gurus as $newGurus)
                               <option value='{{$newGurus->id}}'>{{$newGurus->nama_guru}}</option>
                           @endforeach
                       </select>
                    </div>
                    <div class='form-group'>
                        <label for='kode'>Kode CoCard</label>
                        <select name='kode' id='kode' data-placeholder='Pilih Data Kode CoCard' class='select2 form-control' required>
                                <option value=''>--- Pilih Kode CoCard ---</option>
                            @foreach($Cocard as $newCocard)
                                <option value='{{$newCocard->kode}}'>{{$newCocard->kode}}</option>
                            @endforeach
                        </select>
                    </div>
                    {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Generate</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                </form>
            </div>

        </div>
    </div>

</div>
