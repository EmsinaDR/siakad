<style>
</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

    <section class='content'>

        {{-- {{ dd($wakakur) }} --}}

        {{-- <x-btn-save>submit</x-btn-save> --}}

        <x-plugins-tabel-header></x-plugins-tabel-header>
        <x-plugins-multiple-select-header></x-plugins-multiple-select-header>

        {{-- @include('components.include-ekaldik') --}}




    </section>

</x-layout>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>
