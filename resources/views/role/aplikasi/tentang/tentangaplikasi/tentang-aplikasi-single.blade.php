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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <!-- Konten -->
                        <form id='updateurl' action='{{ route('tentang-aplikasi.update', $data->id) }}' method='POST'>
                            @csrf
                            @method('PATCH')
                            <div class='form-group'>
                                <i class='fas fa-sticky-note'></i><label for='content'>Konten</label>
                                <textarea name='content' id='content' rows='3' class='editor form-control' placeholder='Data konten'>{!! $data->content !!}</textarea>
                            </div>
                            <button id='kirim' type='submit'
                                class='btn float-right btn-default bg-primary btn-xl mt-4'>
                                Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
