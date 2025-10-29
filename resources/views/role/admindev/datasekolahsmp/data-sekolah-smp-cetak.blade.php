                    @php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
@endphp
<x-layout-cetak>

    <link rel='stylesheet' href='{{ asset('css/layout-cetak.css') }}'>
    {{-- Undangan Rapat --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <div class="mt-4"></div>

    Isi Cetak
    </div>
</x-layout-cetak>