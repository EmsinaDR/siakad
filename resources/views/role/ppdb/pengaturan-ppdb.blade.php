@php
    //Pengaturan PPDB
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


            <div class='ml-2 my-4'>
                <div class="card">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Pengaturan PPDB</h3>
                    </div>
                    <div class='card-body'>
                        <form id='#id' action='' method='POST'>
                            @csrf
                            @method('POST')
                            {{-- blade-formatter-disable --}}
                            <x-inputallin>type:Pendaftaran:Biaya Pendaftaran:nominal:id_nominal:{{ isset($pengaturan->isi['nominal']) ? $pengaturan->isi['nominal'] : '' }}:Required</x-inputallin>
                            <x-inputallin>type:Jumlah Peserta:Jumlah Peserta:jumlah_peserta:id_jumlah_peserta:{{ isset($pengaturan->isi['jumlah_peserta']) ? $pengaturan->isi['jumlah_peserta'] : '' }}:Required</x-inputallin>
                            {{-- blade-formatter-enable --}}

                            <button type='submit' class='btn btn-default bg-primary btn-md'> Kirim</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
{{-- <button class='btn btn-warning btn-sm' onclick='PembayaranPPDB()'><i class='fa fa-edit right'></i> Edit</button> --}}
{{--
onclick='PembayaranPPDB()'
 --}}

<script>
    function PembayaranPPDB(data) {
        var PembayaranPPDB = new bootstrap.Modal(document.getElementById('PembayaranPPDB'));
        PembayaranPPDB.show();
        document.getElementById('Eid').value = data.id;
    }
</script>

{{-- Modal Edit Data Awal --}}
<div class='modal fade' id='PembayaranPPDB' tabindex='-1' aria-labelledby='LabelPembayaranPPDB' aria-hidden='true'>
    <div class='modal-dialog modal-lg'>
        <div class='modal-content'>
            <div class='modal-header bg-primary'>
                <h5 class='modal-title' id='LabelPembayaranPPDB'>
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
