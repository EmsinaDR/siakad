@php
$activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);

$title = "aaa";
$breadcrumb ="aa/bbaaa";
@endphp
<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2'>
        <x-plugins-tabel-header></x-plugins-tabel-header>
        <x-plugins-multiple-select-header></x-plugins-multiple-select-header>
        <div class='card'>
            <div class='ml-2'>

                @php
                $field = [
                "Nama" => 'nama',
                "Kelas" => 'kelas',
                "Alamat" => 'alamat',

                ]
                @endphp




                @foreach ($field as $key => $value)
                <div class='form-group'>
                    <label for='{{ $value }}'>{{ $key }}</label>
                    <input type='text' class='form-control' id='{{ $value }}' name='{{ $value }}' placeholder='{{ $key }}' required>
                </div>
                @endforeach

                <div class='form-group'>
                    <label for='id_inputname_input'>LabelPlaceholder</label>
                    <input type='text' class='form-control' id='id_inputname_input' name='name_input' placeholder='LabelPlaceholder' required>
                </div>
                <div class="row">
                    @foreach ($field as $key => $value)
                    <div class="col-6">
                        <div class='form-group'>
                            <label for='id_inputname_input'>LabelPlaceholder</label>
                            <input type='text' class='form-control' id='id_inputname_input' name='name_input' placeholder='LabelPlaceholder' required>
                        </div>
                    </div>
                    @endforeach
                </div>

                <x-btn>button/kirim/fa fa-camera/btn-danger</x-btn>

            </div>
        </div>
    </section>

</x-layout>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>
