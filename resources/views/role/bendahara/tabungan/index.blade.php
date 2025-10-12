//ViewTabungan
<x-layout>
    @php
    $activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    @endphp
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
            <div class='card-body'>
                   <div class='row float-right'>
                       <x-btnjs>submit/Tambah Data/fa fa-plus/btn btn-primary btn-xl bg-primary btn-app/ViewTabungan()</x-btnjs>
                   </div>
            </div>
            {{-- Papan Informasi --}}

                   <!--Car Header-->
                   <div class='card-header bg-primary mx-2'>
                       <h3 class='card-title'>{{ $title }}</H3>
                   </div>
                   <!--Car Header-->


            <div class='ml-2 my-4'>
                   Dasboard
            </div>

        </div>

    </section>
</x-layout>

<button class='btn btn-warning btn-sm' onclick='ViewTabungan()'><i class='fa fa-edit right'></i> Edit</button>

<script>
    function ViewTabungan(data) {
        var ViewTabungan = new bootstrap.Modal(document.getElementById('ViewTabungan'));
        ViewTabungan.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='ViewTabungan' tabindex='-1' aria-labelledby='ViewTabungan' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='ViewTabungan'>
                    Tambah Data Baru
                </h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>

                content

            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
            </div>
        </div>
    </div>

</div>