<x-guest-layout>
    <!-- Menggunakan min-height untuk memastikan konten berada di tengah -->
    <div class="d-flex justify-content-center align-items-start"
        style="min-height: 100vh; background-color: #f4f6f9; padding-top: 60px;">
        <!-- Box form diperbesar dan dirapikan -->
        <div class="w-full"
            style="max-width: 500px; background: white; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.15); padding: 30px 20px;margin-top: 250px">

            <!-- Isi form dengan padding tambahan untuk jarak antar elemen -->
            <div class="card-body">

                <!-- Menampilkan pesan sukses jika ada -->
                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form reset password -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="card-body p-4">

                        <!-- Logo Sekolah di atas header form -->
                        <div class="text-center mb-3">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo Sekolah"
                                style="max-width: 150px; height: 150; object-fit: cover; border-radius: 50%; margin-top: -150px;">
                        </div>

                        <!-- Garis pembatas -->
                        <hr class="mb-4" style="border-top: 2px solid #007bff; width: 60%; margin: 0 auto;">

                        <!-- Header -->
                        <div class="card-header text-center p-2 rounded mb-4"
                            style="background-color: #007bff; color: white; font-size: 1.5rem;">
                            {{ __('Reset Password') }}
                        </div>

                        <!-- Input Email -->
                        <div class="mb-4 p-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Masukkan email Anda">

                            @error('email')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Tombol submit -->
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</x-guest-layout>
