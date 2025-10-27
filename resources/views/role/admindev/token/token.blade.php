@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
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
            <!--Card Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</h3>
            </div>
            <!--Card Header-->
            <div class='row m-2'>
                <div class='col-xl-2'>
                    <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'>
                        <i class='fa fa-plus'></i> Tambah Data
                    </button>
                </div>
                <div class='col-xl-10'></div>
            </div>
            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        @php
                            // Data awal
                            $token = 'token';
                            $namasek = 'namasek';

                            // Gabungkan kedua string
                            $combinedString = $token . $namasek; // Ini jadi 'tokennamase'

                            // Hash gabungan string tersebut
                            $hashedCombinedString = Hash::make($combinedString);

                            // Simulasi hash yang sudah disimpan sebelumnya (misal ini berasal dari database)
                            $hashedToken = Hash::make('token'); // Ini untuk 'token'
                            $hashedNamasek = Hash::make('namasek'); // Ini untuk 'namasek'

                            // Gabungkan hash yang sudah ada (meskipun gabungan ini TIDAK akan menghasilkan hash yang sama)
                            $combinedHash = $hashedToken . $hashedNamasek;

                            // Verifikasi apakah hash gabungan yang kamu buat sama dengan hash yang sudah ada
                            if (Hash::check($combinedString, $hashedCombinedString)) {
                                echo 'Hash gabungan cocok!';
                            } else {
                                echo 'Hash gabungan tidak cocok!';
                            }

                        @endphp
                        <!-- Konten -->
                        @if (session('success'))
                            <p style="color: green;">{{ session('success') }}</p>
                        @endif

                        <div class="card">
                            <div class='form-group'>
                                <label for='terial_end'>Expired</label>
                                <input type='text' class='form-control' id='terial_end' name='terial_end'
                                    value='{{ Carbon::create($Identitas->trial_ends_at)->translatedformat('l, d F Y') }}'
                                    required>
                            </div>

                        </div>

                        <form action="{{ route('tokenapp.update') }}" method="POST">
                            @csrf
                            <div class='form-group'>
                                <label for='detailguru_id'>Nama Pengguna</label>
                                <select id='paket' name='paket' class='form-control' placeholder='Paket'
                                    style='width: 100%;'>
                                    <option value=''></option>
                                    <option value="Gratis">Gratis</option>
                                    <option value="Trial">Trial</option>
                                    <option value="Kerjasama" selected>Kerjasama</option>
                                    <option value="Basic">Basic</option>
                                    <option value="Premium">Premium</option>
                                </select>
                            </div>
                            <div class='form-group'>
                                <label for='disk'>Serial Hardisk</label>
                                <input type='text' class='form-control' id='disk' name='disk' placeholder='placeholder' value='{{ get_disk_serials() }}'>
                            </div>
                            <div class="row">
                                <div class='form-group col-xl-6'>
                                    <label for='trial_end'>Expired</label>
                                    <input type='date' class='form-control' id='trial_end' name='trial_end'
                                        placeholder='placeholder'>
                                </div>
                                <div class='form-group col-xl-6'>
                                    <label for="new_token">Token Baru</label>
                                    <input type="password" id="new_token" name="new_token" class='form-control'
                                        required>
                                </div>
                            </div>
                            <button type='submit' class='btn float-right btn-default bg-primary btn-md'>Ganti
                                Token</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
