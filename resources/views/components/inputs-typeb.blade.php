{{-- {{$slot}} --}}
{{--
textarea
Label:name:id:requeired:textarea:5
file
Label:name:id:requeired:file
Placeholder
name
id
Custom
type
row
--}}
<style>
    textarea {
      resize: none; /* Mencegah pengguna mengubah ukuran */
    }
  </style>
@php

$pairs = explode('/', $slot); // Memisahkan berdasarkan tanda /
$result = [];
for($i=0;$i< count($pairs);$i++):
$pairs[$i]=explode(':', $pairs[$i]);
endfor;
@endphp @for($i=0;$i< count($pairs);$i++)
<div class='form-group'>
    <label for='{{ $pairs[$i][2] }}'>{{ $pairs[$i][0] }}</label>
    @if($pairs[$i][4] === 'textarea')
    <textarea type='text' class='form-control' id='{{ $pairs[$i][2] }}' rows='{{ $pairs[$i][5] }}' name='{{ $pairs[$i][1] }}' placeholder='{{ $pairs[$i][0] }}' {{ $pairs[$i][3] }}></textarea>
    @elseif($pairs[$i][4] === 'file')
    <input class='form-control' type='file' id='{{ $pairs[$i][2] }}' name='{{ $pairs[$i][1] }}' placeholder='{{ $pairs[$i][0] }}' {{ $pairs[$i][3] }}>

    @elseif($pairs[$i][4] === 'dropdown')
    @else
    <input type='text' class='form-control' id='{{ $pairs[$i][2] }}' name='{{ $pairs[$i][1] }}' placeholder='{{ $pairs[$i][0] }}' {{ $pairs[$i][3] }}>
    @endif
    </div>
    @endfor
