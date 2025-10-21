@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout-cetak>

    @if ((int) request()->segment(3) === 125)
        Data 125
    @elseif((int) request()->segment(3) === 126)
        Data 126
    @else
        hasil else
    @endif

</x-layout-cetak>
