
@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
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
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>


            <div class='ml-2 my-4'>
                   content
            </div>


        </div>

    </section>
</x-layout>
