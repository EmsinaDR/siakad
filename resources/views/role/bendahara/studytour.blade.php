@php
$activecrud = collect([2,4, 6, 8])->search(Auth::user()->id);



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

                content

            </div>
        </div>
    </section>

</x-layout>
<x-plugins-tabel-footer></x-plugins-tabel-footer>
<x-plugins-multiple-select-footer></x-plugins-multiple-select-footer>

