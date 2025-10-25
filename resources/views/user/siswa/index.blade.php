<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

    <section class='content'>
        aa
        {{-- {{ dd($wakakur) }} --}}

        {{-- <x-btn-save>submit</x-btn-save> --}}

        <x-plugins-tabel-header></x-plugins-tabel-header>
        <x-plugins-multiple-select-header></x-plugins-multiple-select-header>

        {{-- @include('components.include-ekaldik') --}}
        @foreach($datas as $data)

        {{ $data->nama_siswa }}

        @endforeach



    </section>

</x-layout>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer>
    </x-plugins-multiple-select-header>
