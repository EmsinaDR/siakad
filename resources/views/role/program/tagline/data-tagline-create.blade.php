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


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               <div class="row p-2">
                <div class="col-xl-12">
{{-- <x-inputallin>readonly:Nama Dokumen::::{{$DataPPKS->nama_dokumen}}:readonly</x-inputallin> --}}
                </div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id="form-tagline" action="{{ route('tagline.store') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    placeholder="Judul Tagline" required>
                            </div>

                            <div class="form-group">
                                <label for="isi">Isi Tagline</label>
                                <textarea class="content form-control" id="isi" name="isi" placeholder="Isi dari tagline..." required></textarea>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="is_aktif" name="is_aktif"
                                    value="1" checked>
                                <label class="form-check-label" for="is_aktif">Aktifkan</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
