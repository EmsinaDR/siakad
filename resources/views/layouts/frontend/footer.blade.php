<!-- Start Footer Area -->
<footer class="footer">
    <!-- Start Footer Top -->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <!-- Single Widget -->
                    <div class="single-footer f-about">
                        <div class="logo">
                            <a href="index.html">
                                <img src="{{ asset('img/logo/logo.png') }}" alt="#" />
                            </a>
                        </div>
                        <p>
                            {{ $Identitas->namasek }}
                        </p>
                        <ul class="social">
                            <li>
                                <a href="#"><i
                                        class="fab fa-facebook-f"></i>{{ $Identitas->facebook_fanspage ?? '' }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-twitter"></i>{{ $Identitas->twiter ?? '' }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-instagram"></i> {{ $Identitas->instagram ?? '' }}</a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-youtube"></i>{{ $Identitas->youtube ?? '' }}</a>
                            </li>
                            <li>
                                <a href="#"><i
                                        class="fab fa-pinterest-p"></i>{{ $Identitas->pinterest ?? '' }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- End Single Widget -->
                </div>
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Solutions</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Marketing</a></li>
                                    <li><a href="javascript:void(0)">Analytics</a></li>
                                    <li><a href="javascript:void(0)">Commerce</a></li>
                                    <li><a href="javascript:void(0)">Insights</a></li>
                                    <li><a href="javascript:void(0)">Promotion</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Support</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Pricing</a></li>
                                    <li><a href="javascript:void(0)">Documentation</a></li>
                                    <li><a href="javascript:void(0)">Guides</a></li>
                                    <li><a href="javascript:void(0)">API Status</a></li>
                                    <li><a href="javascript:void(0)">Live Support</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Company</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">About Us</a></li>
                                    <li><a href="javascript:void(0)">Our Blog</a></li>
                                    <li><a href="javascript:void(0)">Jobs</a></li>
                                    <li><a href="javascript:void(0)">Press</a></li>
                                    <li><a href="javascript:void(0)">Contact Us</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- Single Widget -->
                            <div class="single-footer f-link">
                                <h3>Legal</h3>
                                <ul>
                                    <li>
                                        <a href="javascript:void(0)">Terms & Conditions</a>
                                    </li>
                                    <li><a href="javascript:void(0)">Privacy Policy</a></li>
                                    <li>
                                        <a href="javascript:void(0)">Catering Services</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)">Customer Relations</a>
                                    </li>
                                    <li><a href="javascript:void(0)">Innovation</a></li>
                                </ul>
                            </div>
                            <!-- End Single Widget -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Footer Top -->
</footer>
<!--/ End Footer Area -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p><i class="fa fa-copyright"></i> Copyright {{ date('Y') }} by Grad School

                    | Design: <a href="https://www.facebook.com/septa344347" rel="sponsored" target="_parent">Admin Ata
                        Digital</a><br>

                </p>
            </div>
        </div>
    </div>
</footer>
