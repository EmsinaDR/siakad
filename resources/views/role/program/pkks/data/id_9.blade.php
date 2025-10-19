@php
    use Illuminate\Support\Carbon;
    $Identitas = \App\Models\Admin\Identitas::first();
    $Tapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp
<x-layout-view-pkks>
    <x-slot:judul>
        <h2>DATA SOP MADRASAH</h2>
    </x-slot:judul>
    <section>
        @foreach ($DataSOPs as $DataSOP)
            <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
            <div class="container">
                <x-kop-surat-cetak></x-kop-surat-cetak>
                <h5 class="header-title mt-5">DATA SOP {{ strtoupper($DataSOP->judul) }}</h5>
                <style>
                    #myTable,
                    #myTable td,
                    #myTable th {
                        border: none !important;
                        border-collapse: collapse;
                    }
                </style>




            </div>
        @endforeach
    </section>
</x-layout-view-pkks>
