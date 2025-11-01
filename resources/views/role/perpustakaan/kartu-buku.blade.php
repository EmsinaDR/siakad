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


            <div class='row m-2'>
                {{-- blade-formatter-disable --}}
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' data-toggle='modal' data-target='#blankoKartuBuku'><i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


                <div class='ml-2 my-4'>
                    content
                </div>


            </div>

    </section>
</x-layout>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='blankoKartuBuku' tabindex='-1' aria-labelledby='LabelblankoKartuBuku' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
           <div class='modal-content'>
               <div class='modal-header bg-primary'>
                   <h5 class='modal-title' id='LabelblankoKartuBuku'>
                       Tambah Data Baru
                   </h5>
                   <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                   </button>
               </div>
               <div class='modal-body'>
{{-- {{route('url.store')}} --}}
                   <form id='blankoKartuBuku-form' action='' method='POST'>
                          @csrf
                          @method('POST')
                         content_form

                           {{-- blade-formatter-disable --}}
                           <div class='modal-footer'>
                               <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                               <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
                           </div>
                           {{-- blade-formatter-enable --}}
                   </form>
           </div>

            </div>
    </div>

</div>