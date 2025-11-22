<!DOCTYPE html>
<html lang="en">

@include('layouts.frontend.header')

<link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">

@php
    $logoIco = $Identitas->namasek === 'Sekolah Cipta IT' ? 'img/dev/logo.ico' : 'img/logo.ico';
    $logo = $Identitas->namasek === 'Sekolah Cipta IT' ? 'img/dev/logo.png' : 'img/logo.png';
@endphp
{{-- <pre>{{ var_dump($Identitas) }}</pre> --}}

<link rel="icon" type="image/x-icon" href="{{ secure_asset($logoIco) }}">

<body>

    @include('layouts.frontend.navbar')

    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <video autoplay muted loop id="bg-video">
            <source src="{{ asset('frontend/assets/images/course-video.mp4') }}" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="caption">
                <h6>Graduate School of Management</h6>
                <h2><em>Your</em> Classroom</h2>
                <div class="main-button">
                    <div class="scroll-to-section"><a href="#section2">Discover more</a></div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->


    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="features-post">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-pencil"></i>All Courses</h4>
                            </div>
                            <div class="content-hide">
                                <p>Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In mollis eros a
                                    posuere imperdiet. Donec maximus elementum ex. Cras convallis ex rhoncus, laoreet
                                    libero eu, vehicula libero.</p>
                                <p class="hidden-sm">Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                                    mollis eros a posuere imperdiet.</p>
                                <div class="scroll-to-section"><a href="#section2">More Info.</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="features-post second-features">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-graduation-cap"></i>Virtual Class</h4>
                            </div>
                            <div class="content-hide">
                                <p>Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In mollis eros a
                                    posuere imperdiet. Donec maximus elementum ex. Cras convallis ex rhoncus, laoreet
                                    libero eu, vehicula libero.</p>
                                <p class="hidden-sm">Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                                    mollis eros a posuere imperdiet.</p>
                                <div class="scroll-to-section"><a href="#section3">Details</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="features-post third-features">
                        <div class="features-content">
                            <div class="content-show">
                                <h4><i class="fa fa-book"></i>Real Meeting</h4>
                            </div>
                            <div class="content-hide">
                                <p>Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In mollis eros a
                                    posuere imperdiet. Donec maximus elementum ex. Cras convallis ex rhoncus, laoreet
                                    libero eu, vehicula libero.</p>
                                <p class="hidden-sm">Curabitur id eros vehicula, tincidunt libero eu, lobortis mi. In
                                    mollis eros a posuere imperdiet.</p>
                                <div class="scroll-to-section"><a href="#section4">Read More</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class='card-body'>
        @include('layouts.frontend.counter')
        <!-- Start Features Area -->
        <section id="features" class="features section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h3 class="wow zoomIn" data-wow-delay=".2s">Visi & Misi</h3>
                            <h2 class="wow fadeInUp" data-wow-delay=".4s">
                                {{ $Identitas->visi }}
                            </h2>
                            <h4 class="wow fadeInUp" data-wow-delay=".6s">
                                {{ $Identitas->misi }} </h4>
                        </div>
                    </div>
                </div>
                {{-- Script tambahan halaman --}}
                <div class="row">

                    <!-- PPDB -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-graduation-cap fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">PPDB</h6>
                                    <span class="text-muted">Portal penerimaan peserta didik baru.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Absensi -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-qrcode fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Absensi Berbasis QRCode</h6>
                                    <span class="text-muted">Portal Absensi Siswa dan Guru.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Kelulusan -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-certificate fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Kelulusan dan Alumni</h6>
                                    <span class="text-muted">Portal Data Alumni</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- E-Learning -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-book fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">E-Learning System</h6>
                                    <span class="text-muted">
                                        Sistem e-learning dengan pengelolaan dokumen nilai & tugas.
                                    </span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Keuangan -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-wallet fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Keuangan</h6>
                                    <span class="text-muted">
                                        Manajemen pembayaran siswa & anggaran sekolah.
                                    </span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Perpustakaan -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-book-open fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Perpustakaan</h6>
                                    <span class="text-muted">Manajemen perpustakaan digital terintegrasi.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- BK -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".4s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-headset fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Bimbingan Konseling</h6>
                                    <span class="text-muted">Laporan konseling rapi & siap akreditasi.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- CBT -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-pencil-alt fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">CBT dan Bank Soal</h6>
                                    <span class="text-muted">Terintegrasi dengan sistem ujian digital.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Perangkat Test -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-file-alt fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Perangkat Test</h6>
                                    <span class="text-muted">Generator dokumen SAS, PTS, PAT, PAS.</span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                    <!-- Backup Database -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-feature wow fadeInUp" data-wow-delay=".6s">
                            <div class="d-flex align-items-start gap-2 mb-2">
                                <i class="fa fa-database fa-lg mt-1"></i>
                                <div>
                                    <h6 class="mb-0">Database Backups</h6>
                                    <span class="text-muted">
                                        Pencadangan data otomatis secara berkala.
                                    </span>
                                </div>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary mt-3">Detail</a>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <!-- End Features Area -->

        <!-- Start Achievement Area -->
        <section class="our-achievement section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 col-md-12 col-12">
                        <div class="title">
                            <h2>Laboratorium</h2>
                            <p>
                                There are many variations of passages of Lorem Ipsum available,
                                but the majority.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-achievement wow fadeInUp" data-wow-delay=".2s">
                                    <h3 class="counter">
                                        <span id="secondo1" class="countup" cup-end="100">100</span>%
                                    </h3>
                                    <p>satisfaction</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-achievement wow fadeInUp" data-wow-delay=".4s">
                                    <h3 class="counter">
                                        <span id="secondo2" class="countup" cup-end="120">120</span>K
                                    </h3>
                                    <p>Happy Users</p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="single-achievement wow fadeInUp" data-wow-delay=".6s">
                                    <h3 class="counter">
                                        <span id="secondo3" class="countup" cup-end="125">125</span>k+
                                    </h3>
                                    <p>Downloads</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Achievement Area -->
    </div>

    <section class="section why-us" data-section="section2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Kenapa {{ $Identitas->namasek }}</h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id='tabs'>
                        <ul>
                            <li><a href='#tabs-1'>Best Education</a></li>
                            <li><a href='#tabs-2'>System Management</a></li>
                            <li><a href='#tabs-3'>Data Center</a></li>
                            <li><a href='#tabs-4'>Guru Berkualitas</a></li>
                            <li><a href='#tabs-5'>Fasilitas</a></li>
                        </ul>
                        <section class='tabs-content'>
                            <article id='tabs-1'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset('frontend/assets/images/choose-us-image-01.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Best Education</h4>
                                        <p>Grad School is free educational HTML template with Bootstrap 4.5.2 CSS
                                            layout. Feel free to use it for educational or commercial purposes. You may
                                            want to make <a href="https://paypal.me/templatemo" target="_parent"
                                                rel="sponsored">a little donation</a> to TemplateMo. Please tell your
                                            friends about us. Thank you.</p>
                                    </div>
                                </div>
                            </article>
                            <article id='tabs-2'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="assets/images/choose-us-image-02.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Top Level</h4>
                                        <p>You can modify this HTML layout by editing contents and adding more pages as
                                            you needed. Since this template has options to add dropdown menus, you can
                                            put many HTML pages.</p>
                                        <p>Suspendisse tincidunt, magna ut finibus rutrum, libero dolor euismod odio,
                                            nec interdum quam felis non ante.</p>
                                    </div>
                                </div>
                            </article>
                            <article id='tabs-3'>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="assets/images/choose-us-image-03.png" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Quality Meeting</h4>
                                        <p>You are NOT allowed to redistribute this template ZIP file on any template
                                            collection website. However, you can use this template to convert into a
                                            specific theme for any kind of CMS platform such as WordPress. For more
                                            information, you shall <a rel="nofollow"
                                                href="https://templatemo.com/contact" target="_parent">contact
                                                TemplateMo</a> now.</p>
                                    </div>
                                </div>
                            </article>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section coming-soon" data-section="section3">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-xs-12">
                    <div class="continer centerIt">
                        <div>
                            <h4>Take <em>any online course</em> and win $326 for your next class</h4>
                            <div class="counter">

                                <div class="days">
                                    <div class="value">00</div>
                                    <span>Days</span>
                                </div>

                                <div class="hours">
                                    <div class="value">00</div>
                                    <span>Hours</span>
                                </div>

                                <div class="minutes">
                                    <div class="value">00</div>
                                    <span>Minutes</span>
                                </div>

                                <div class="seconds">
                                    <div class="value">00</div>
                                    <span>Seconds</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="right-content">
                        <div class="top-content">
                            <h6>Register your free account and <em>get immediate</em> access to online courses</h6>
                        </div>
                        <form id="contact" action="" method="get">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Your Name" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <input name="email" type="text" class="form-control" id="email"
                                            placeholder="Your Email" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <input name="phone-number" type="text" class="form-control"
                                            id="phone-number" placeholder="Your Phone Number" required="">
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="button">Get it now</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section courses" data-section="section4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Guru dan Karyawan</h2>
                    </div>
                </div>
                <div class="owl-carousel owl-theme">
                    @foreach ($Gurus as $Guru)
                        <div class="item">
                            {{-- <img src="{{asset('img/guru//foto/AS.png')}}" alt="Course #1"> --}}
                            <div class="down-content">
                                <h4>{{ $Guru->nama_guru }},{{ $Guru->gelar }}</h4>
                                <p>You can get free images and videos for your websites by visiting Unsplash, Pixabay,
                                    and
                                    Pexels.</p>
                                <div class="author-image">
                                    <img src="{{ asset('img/guru//foto/' . $Guru->kode_guru . '.png') }}"
                                        alt="Author {{ $Guru->kode_guru }}">
                                </div>
                                <div class="text-button-pay">
                                    <a href="#">Detail <i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <section class="section video" data-section="section5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <div class="left-content">
                        <span>our presentation is for you</span>
                        <h4>Watch the video to learn more <em>about Grad School</em></h4>
                        <p>You are NOT allowed to redistribute this template ZIP file on any template collection
                            website. However, you can use this template to convert into a specific theme for any kind of
                            CMS platform such as WordPress. You may <a rel="nofollow"
                                href="https://templatemo.com/contact" target="_parent">contact TemplateMo</a> for
                            details.
                            <br><br>Suspendisse tincidunt, magna ut finibus rutrum, libero dolor euismod odio, nec
                            interdum quam felis non ante.
                        </p>
                        <div class="main-button"><a rel="nofollow" href="https://fb.com/templatemo"
                                target="_parent">External URL</a></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <article class="video-item">
                        <div class="video-caption">
                            <h4>Power HTML Template</h4>
                        </div>
                        <figure>
                            <a href="https://www.youtube.com/watch?v=r9LtOG6pNUw" class="play"><img
                                    src="assets/images/main-thumb.png"></a>
                        </figure>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section contact" data-section="section6">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Let’s Keep In Touch</h2>
                    </div>
                </div>
                <div class="col-md-6">

                    <!-- Do you need a working HTML contact-form script?

                    Please visit https://templatemo.com/contact page -->

                    <form id="contact" action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset>
                                    <input name="name" type="text" class="form-control" id="name"
                                        placeholder="Your Name" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset>
                                    <input name="email" type="text" class="form-control" id="email"
                                        placeholder="Your Email" required="">
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your message..."
                                        required=""></textarea>
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="button">Send Message Now</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <div id="map">
                        <iframe
                            src="https://maps.google.com/maps?q=Av.+L%C3%BAcio+Costa,+Rio+de+Janeiro+-+RJ,+Brazil&t=&z=13&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="422px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('layouts.frontend.footer')
    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('frontend/assets/js/isotope.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/lightbox.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/tabs.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/video.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick-slider.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>

    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
            var
                direction = section.replace(/#/, ''),
                reqSection = $('.section').filter('[data-section="' + direction + '"]'),
                reqSectionPos = reqSection.offset().top - 0;

            if (isAnimate) {
                $('body, html').animate({
                        scrollTop: reqSectionPos
                    },
                    800);
            } else {
                $('body, html').scrollTop(reqSectionPos);
            }

        };

        var checkSection = function checkSection() {
            $('.section').each(function() {
                var
                    $this = $(this),
                    topEdge = $this.offset().top - 80,
                    bottomEdge = topEdge + $this.height(),
                    wScroll = $(window).scrollTop();
                if (topEdge < wScroll && bottomEdge > wScroll) {
                    var
                        currentId = $this.data('section'),
                        reqLink = $('a').filter('[href*=\\#' + currentId + ']');
                    reqLink.closest('li').addClass('active').
                    siblings().removeClass('active');
                }
            });
        };

        $('.main-menu, .scroll-to-section').on('click', 'a', function(e) {
            if ($(e.target).hasClass('external')) {
                return;
            }
            e.preventDefault();
            $('#menu').removeClass('active');
            showSection($(this).attr('href'), true);
        });

        $(window).scroll(function() {
            checkSection();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@srexi/purecounterjs/dist/purecounter_vanilla.js"></script>
    <script>
        new PureCounter();
    </script>

</body>

</html>
