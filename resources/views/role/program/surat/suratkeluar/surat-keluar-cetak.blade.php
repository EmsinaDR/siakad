@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout-cetak>
    {{-- data_judul --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        
        {!! $content !!}
        {{-- @dump($data) --}}
    </div>
    {{-- data_judul --}}
</x-layout-cetak>
