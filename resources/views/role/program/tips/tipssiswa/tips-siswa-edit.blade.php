@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea,
        .pesan {
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
                <div class="col-xl-2">
                    <a href="{{ route('pesan-tips.index') }}" class="btn btn-secondary btn-md w-100">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <form id='update' action='{{ route('pesan-tips.update', $data->id) }}' method='POST'>
                            @csrf
                            @method('PATCH')
                            <div class='form-group'>
                                <label for='judul'>Judul</label>
                                <input type='text' class='form-control' id='judul' name='judul'
                                    placeholder='Judul pesan' value='{{ $data->judul }}' required>
                            </div>
                            <div class='form-group'>
                                <i class='fas fa-sticky-note pr-2'></i><label for='content'>Isi Pesan</label>
                                <textarea name='content' id='content' rows='3' class='pesan form-control'
                                    placeholder='Masukkan Isi Pesan Singkat'>{{ $data->content }}</textarea>
                            </div>
                            <div class="col-xl-12">
                                <button type='submit'
                                    class='btn btn-default bg-primary btn-md float-right'>Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.remove(); // Optional kalau sudah pernah inisialisasi sebelumnya
        tinymce.init({
            selector: '.pesan',
            menubar: false,
            plugins: 'link lists',
            toolbar: 'undo redo | bold italic underline | bullist numlist | link',
            height: 550,
            branding: false,
            resize: false
        });
    });
</script>
