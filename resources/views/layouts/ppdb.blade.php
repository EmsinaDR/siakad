<!DOCTYPE html>
<html lang="id">

@include('layouts.ppdb.header')
<x-property-header></x-property-header>

<body class="bg-light py-4">

    {{-- Tempat konten dimasukkan --}}
    <main class="container">
        @yield('content')
    </main>
    <x-footer></x-footer>
</body>

</html>

{{-- @extends('layouts.ppdb')
@section('title', 'Data Siswa')

@section('content')
    <h1>Data Siswa</h1>

    <p>Ini halaman content Bro.</p>
@endsection --}}
