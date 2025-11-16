<style>
    #indikator_pecapaian,
    #Eindikator_pecapaian,
    #cindikator_pecapaian {



        resize: none;
    }

</style>

<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>


    <section class='content'>

        {{-- {{ dd($wakakur) }} --}}

        {{-- <x-btn-save>submit</x-btn-save> --}}

        @include('components.include-ekaldik')




    </section>

</x-layout>
