<x-layout-view-pkks>
    <x-slot:judul>SUSUNAN DAN TUGAS ORGANISASI</x-slot:judul>
    <section>
        @foreach ($DataTupoksis as $DataTupoksi)
            <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
            <div class="container">
                <x-kop-surat-cetak></x-kop-surat-cetak>
                <h5 class="header-title mt-5">TUGAS POKOK DAN FUNGSI (TUPOKSI) {{ $DataTupoksi->bidang }}</h5>
                <h5 class="header-title">{{ $Identitas->namasek }}</h5>
                <h5 class="header-title mb-5">Tahun Pelajaran {{ $Tapels->tapel }} - {{ $Tapels->tapel + 1 }}</h5>
                {!! $DataTupoksi->isi !!}
                {{-- @if (!$loop->last)
            <div class="page-break"></div>
        @endif --}}
            </div>
        @endforeach
    </section>
</x-layout-view-pkks>
