@php
//content
use Illuminate\Support\Carbon;
\Carbon\Carbon::setLocale('id');
@endphp
<x-layout>
    <style>
        textarea {
            resize: none;
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
                     <a href="{{ route('data-referensi-sekolah-tingkat-smp.index') }}" class="btn btn-secondary btn-md w-100"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='#id' action='{{route('data-referensi-sekolah-tingkat-smp.update', $data->id)}}' method='POST'>
                            @csrf
                            @method('PATCH')
                            <div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->ceklist}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->tanggal_kunjungan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nsm}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->npsn}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->akreditasi}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_sekolah}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->alamat}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->kecamatan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->kelurahan}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->status}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->siswa_l}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->siswa_p}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_kepala}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nohp_kepala}}' required></div><div class='form-group'>    <label for='{{datafill}}'></label>    <input type='text' class='form-control' id='{{datafill}}' name='{{datafill}}' placeholder='placeholder' value='{{ $data->nama_operator}}' required></div>
                            <button type='submit' class='btn btn-block btn-default bg-primary btn-md float-right'></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>