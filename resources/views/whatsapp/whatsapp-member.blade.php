<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            {{-- rm -rf .wwebjs_auth <br> --}}

            {{-- Papan Informasi --}}
            <div class='card-body'>
                <div class="row">
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>Data Akun</h3>
                    </div>
                    <div class="col-xl-8 my-2"></div>
                </div>
            </div>

            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }} {{ $groupName }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>

                <h3>Grup: {{ $groupName }}</h3>
                <ul>
                    @forelse ($members as $member)
                        <li>{{ $member }}</li> {{-- Kalau cuma nomor WA --}}
                    @empty
                        <li>Tidak ada anggota ditemukan.</li>
                    @endforelse
                </ul>

            </div>

        </div>

    </section>
</x-layout>
