@php
    use Illuminate\Support\Carbon;

    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp

<x-layout-view-pkks>
    <x-slot:judul>
        <h2>BERITA ACARA TUGAS ORGANISASI</h2>
        <h2 class="header-title">{{ strtoupper($Identitas->namasek) }}</h2>
        <h2 class="header-title">{{ strtoupper($Tapels->tapel) }}</h2>
    </x-slot:judul>

    <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
    <section>
        @foreach ($dataRapats as $dataRapat)
            <div class="container">
                <x-kop-surat-cetak />
                <div class="my-4">
                    <h2 class="header-title">DOKUMEN SOSIALISASI PENGURUS</h2>
                    <h4 class="header-title">{{ strtoupper($Identitas->namasek) }}</h4>
                    <h4 class="header-title">{{$dataRapat->Tapel->tapel }} - {{$dataRapat->Tapel->tapel +1 }}</h4>
                </div>
                {!! $dataRapat->notulen !!}

            </div>
            <div class="page-break"></div>
        @endforeach
    </section>
</x-layout-view-pkks>

{{-- <script>
    window.onload = function() {
        window.print();
    };
</script> --}}
