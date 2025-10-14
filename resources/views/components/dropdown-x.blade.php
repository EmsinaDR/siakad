@php
$quter =str_replace('&quot;','"', $sendvar);
$quter = json_decode($quter, true);
$property = explode('/', $property);
@endphp

{{--

single/Label/Placeholder/name/id_name/required/val1/text1

--}}
<div class='form-group'>

    @if($property[0] === 'dropdwon-single')

    <label for='{{ $property[4] }}'>{{ $property[1] }}</label>
    <select name='{{ $property[3] }}' id='{{ $property[4] }}' class='form-control' {{ $property[5] }}>
        <option value='{{ $property['6'] }}'>{{ $property['7'] }}</option>
        @foreach ($quter as $qute)
        <option value='{{ $qute['id'] }}'>{{ $qute['ekstra'] }}</option>
        @endforeach
    </select>


    @elseif($property[0] === 'dropdwon-multiple')

    <label for='{{ $property[4] }}'>{{ $property[1] }}</label>
    <select name='{{ $property[3] }}' id='multiple_{{ $property[4] }}[]' class='form-control' multiple='multiple' data-placeholder='placeholder' {{ $property[5] }}>
        <option value='{{ $property['6'] }}'>{{ $property['7'] }}</option>
        @foreach ($quter as $qute)
        <option value='{{ $qute['id'] }}'>{{ $qute['ekstra'] }}</option>
        @endforeach
    </select>


    @elseif($property[0] === 'email')
    @else

    @endif
</div>
