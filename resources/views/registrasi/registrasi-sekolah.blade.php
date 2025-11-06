@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    // $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    // $urlroot = app('request')->root();
@endphp
<x-layout-registrasi-sekolah>
    {{-- {{ dd($title, $breadcrumb) }} --}}
    <x-slot:title>{{ $title }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>

    <section class="content mx-2 my-4">
        <div class="container">
            <div class="form-container col-lg-10 col-md-10 col-sm-12 mx-auto my-5">
                <!-- Membuat kontainer untuk logo dan form -->
                <div class="d-flex justify-content-center align-items-center mb-4" style="position: relative;">
                    <!-- Logo -->
                    <div class="logo-container" style="position: absolute; top: -70px; z-index: 2;">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Sekolah" class="img-fluid rounded-circle"
                            style="max-width: 150px; border: 3px solid #fff;">
                    </div>

                    <!-- Box Formulir -->
                    <div class="box-form"
                        style="width: 100%; padding-top: 100px; border-radius: 15px; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                        <h2 class="text-center mb-4">Registrasi Sekolah</h2>
                        <form action="{{ route('registrasi-sekolah.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf<div class="m-3">
                                <label for="namasek" class="form-label">Nama Sekolah</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-school"></i></span>
                                    <input type="text" class="form-control rounded" id="namasek" name="namasek"
                                        placeholder="Nama Sekolah" required>
                                </div>
                            </div>

                            <div class="m-3">
                                <label for="namasingkat" class="form-label">Nama Singkat</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-font"></i></span>
                                    <input type="text" class="form-control rounded" id="namasingkat"
                                        name="namasingkat" placeholder="Nama Singkat">
                                </div>
                            </div>

                            <div class="row gap-2 mx-2 d-flex">
                                <!-- Kode Sekolah -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="kode_sekolahan" class="form-label">Kode Sekolah</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="text" class="form-control rounded" id="kode_sekolahan"
                                            name="kode_sekolahan" placeholder="Kode Sekolah">
                                    </div>
                                </div>

                                <!-- Jenjang -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="jenjang" class="form-label">Jenjang</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                        <select class="form-control rounded" id="jenjang" name="jenjang">
                                            <option value="SMP N">SMP N</option>
                                            <option value="SMP S">SMP S</option>
                                            <option value="MTs S">MTs S</option>
                                            <option value="MTs N">MTs N</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- NSM -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="nsm">NSM</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" id="nsm" name="nsm"
                                            placeholder="NSM" required>
                                    </div>
                                </div>

                                <!-- NPSN -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="npsn">NPSN</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" id="npsn" name="npsn"
                                            placeholder="NPSN" required>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="status">Status</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                        <input type="text" class="form-control" id="status" name="status"
                                            placeholder="Status" required>
                                    </div>
                                </div>

                                <!-- Akreditasi -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="akreditasi">Akreditasi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                        <select class="form-control rounded" id="akreditasi" name="akreditasi"
                                            required>
                                            <option value="" disabled selected>Pilih Akreditasi</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="Tidak Terakreditasi">Tidak Terakreditasi</option>
                                        </select>
                                    </div>
                                </div>


                                <!-- No TLP -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="phon">No TLP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control" id="phon" name="phon"
                                            placeholder="No TLP" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row gap-2 mx-2 d-flex">
                                <!-- Email -->
                                <div class="mb-3 col-xl-6">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control rounded" id="email" name="email" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="mb-3 col-xl-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="password" class="form-control rounded" id="password" name="password" placeholder="Password" required>
                                    </div>
                                </div>

                                <!-- No Telepon -->
                                <div class="mb-3 col-xl-6">
                                    <label for="phone" class="form-label">No Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control rounded" id="phone"
                                            name="phone" placeholder="No Telepon">
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3 col-xl-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control rounded" id="alamat"
                                            name="alamat" placeholder="Alamat">
                                    </div>
                                </div>

                                <!-- Desa -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="desa">Desa</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                        <input type="text" class="form-control" id="desa" name="desa"
                                            placeholder="Desa" required>
                                    </div>
                                </div>

                                <!-- Kecamatan -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="kecamatan">Kecamatan</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map"></i></span>
                                        <input type="text" class="form-control" id="kecamatan" name="kecamatan"
                                            placeholder="Kecamatan" required>
                                    </div>
                                </div>

                                <!-- Kabupaten -->
                                <div class="mb-3 col-xl-6">
                                    <label for="kabupaten" class="form-label">Kabupaten</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" class="form-control rounded" id="kabupaten"
                                            name="kabupaten" placeholder="Kabupaten">
                                    </div>
                                </div>

                                <!-- Provinsi -->
                                <div class="mb-3 col-xl-6">
                                    <label for="provinsi" class="form-label">Provinsi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <input type="text" class="form-control rounded" id="provinsi"
                                            name="provinsi" placeholder="Provinsi">
                                    </div>
                                </div>

                                <!-- Logo -->
                                <div class="mb-3 col-xl-6">
                                    <label for="logo" class="form-label">Logo Sekolah</label>
                                    <input type="file" class="form-control rounded" id="logo"
                                        name="logo">
                                </div>
                            </div>

                            <div class="row gap-2 mx-2 d-flex">
                                <!-- Website -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="website">Website</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                                        <input type="text" class="form-control" id="website" name="website"
                                            placeholder="Website" required>
                                    </div>
                                </div>

                                <!-- Facebook -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="facebook">Facebook</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        <input type="text" class="form-control" id="facebook" name="facebook"
                                            placeholder="Facebook" required>
                                    </div>
                                </div>

                                <!-- Facebook Fans Page -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="facebook_fanspage">Facebook Fanspage</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        <input type="text" class="form-control" id="facebook_fanspage"
                                            name="facebook_fanspage" placeholder="Facebook Fanspage" required>
                                    </div>
                                </div>

                                <!-- Facebook Group -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="facebook_group">Facebook Group</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        <input type="text" class="form-control" id="facebook_group"
                                            name="facebook_group" placeholder="Facebook Group" required>
                                    </div>
                                </div>

                                <!-- Twitter -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="twiter">Twitter</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        <input type="text" class="form-control" id="twiter" name="twiter"
                                            placeholder="Twitter" required>
                                    </div>
                                </div>

                                <!-- Instagram -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="instagram">Instagram</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                        <input type="text" class="form-control" id="instagram" name="instagram"
                                            placeholder="Instagram" required>
                                    </div>
                                </div>

                                <!-- WhatsApp Group -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="whatsap_group">WhatsApp Group</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                        <input type="text" class="form-control" id="whatsap_group"
                                            name="whatsap_group" placeholder="WhatsApp Group" required>
                                    </div>
                                </div>

                                <!-- Internet -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="internet">Internet</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-wifi"></i></span>
                                        <input type="text" class="form-control" id="internet" name="internet"
                                            placeholder="Internet" required>
                                    </div>
                                </div>

                                <!-- Speed -->
                                <div class="form-group mb-3 col-xl-6">
                                    <label for="speed">Speed Internet</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                                        <input type="text" class="form-control" id="speed" name="speed"
                                            placeholder="Speed" required>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg w-100 rounded">Daftar
                                    Sekarang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        </div>
    </section>

</x-layout-registrasi-sekolah>
