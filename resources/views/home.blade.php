@extends('layouts/homeLayoutMaster')

@section('title', 'Home')

@section('page-style')
    {{-- Page Css files --}}
    <link href="{{ asset(mix('css/plugins/bootstrap-icons/bootstrap-icons.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/plugins/aos/aos.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/plugins/boxicons/css/boxicons.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/plugins/glightbox/glightbox.min.css')) }}" rel="stylesheet">
    <link href="{{ asset(mix('css/plugins/swiper/swiper-bundle.min.css')) }}" rel="stylesheet">

    <style type="text/css">
        .horizontal-menu.navbar-sticky .app-content {
            padding-top: 2.5rem;
        }
        .horizontal-menu.navbar-sticky .horizontal-menu-wrapper .navbar-horizontal.header-navbar.fixed-top {
            top: 0px;
        }

        #hero {
            width: 100%;
            height: 75vh;
            background: url('/images/one/hero-bg.jpg') top left;
            background-size: cover;
            position: relative;
        }

        #hero .container {
            position: relative;
        }

        #hero h1 {
            margin: 0;
            font-size: 48px;
            font-weight: 700;
            line-height: 56px;
            color: #222222;
            font-family: "Poppins", sans-serif;
        }

        #hero h2 {
            color: #555555;
            margin: 5px 0 30px 0;
            font-size: 24px;
            font-weight: 400;
        }

        #hero .btn-get-started {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 1px;
            display: inline-block;
            padding: 10px 28px;
            border-radius: 4px;
            transition: 0.5s;
            color: #fff;
            background: #106eea;
        }

        #hero .btn-watch-video {
            font-size: 16px;
            transition: 0.5s;
            margin-left: 25px;
            color: #222222;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        #hero .btn-watch-video i {
            color: #106eea;
            font-size: 32px;
            transition: 0.3s;
            line-height: 0;
            margin-right: 8px;
        }

        section {
            padding: 60px 0;
            overflow: hidden;
        }
        .section-bg {
            background-color: #f6f9fe;
        }
        .section-title {
            text-align: center;
            padding-bottom: 30px;
        }
        .section-title h2 {
            font-size: 13px;
            letter-spacing: 1px;
            font-weight: 700;
            padding: 8px 20px;
            margin: 0;
            background: #e7f1fd;
            color: #106eea;
            display: inline-block;
            text-transform: uppercase;
            border-radius: 50px;
        }
        .section-title h3 {
            margin: 15px 0 0 0;
            font-size: 32px;
            font-weight: 700;
        }
        .section-title h3 span {
            color: #106eea;
        }

        .section-title p {
            margin: 15px auto 0 auto;
            font-weight: 600;
            color: #2c2c2c;
        }

        .featured-services .icon-box {
            padding: 30px;
            position: relative;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 0 29px 0 rgb(68 88 144 / 12%);
            transition: all 0.3s ease-in-out;
            border-radius: 8px;
            z-index: 1;
        }
        .featured-services .title {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .featured-services .icon {
            margin-bottom: 15px;
        }
        .featured-services .icon i {
            font-size: 48px;
            line-height: 1;
            color: #106eea;
            transition: all 0.3s ease-in-out;
        }
        .featured-services .title a {
            color: #111;
        }
        .featured-services .description {
            font-size: 15px;
            line-height: 28px;
            margin-bottom: 0;
            color: #2c2c2c;
        }

        .counts {
            padding: 70px 0 60px;
        }
        .counts .count-box {
            padding: 30px 30px 25px 30px;
            width: 100%;
            position: relative;
            text-align: center;
            background: #f1f6fe;
        }
        .counts .count-box i {
            position: absolute;
            top: -28px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 24px;
            background: #106eea;
            color: #fff;
            width: 56px;
            height: 56px;
            line-height: 0;
            border-radius: 50px;
            border: 5px solid #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .counts .count-box span {
            font-size: 36px;
            display: block;
            font-weight: 600;
            color: #062b5b;
        }
        .counts .count-box p {
            padding: 0;
            margin: 0;
            font-family: "Roboto", sans-serif;
            font-size: 14px;
        }

        .clients {
            padding: 15px 0;
            text-align: center;
        }

        .services .icon-box {
            text-align: center;
            border: 1px solid #e2eefd;
            padding: 80px 20px;
            transition: all ease-in-out 0.3s;
            background: #fff;
        }
        .services .icon-box .icon {
            margin: 0 auto;
            width: 64px;
            height: 64px;
            background: #f1f6fe;
            border-radius: 4px;
            border: 1px solid #deebfd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: ease-in-out 0.3s;
        }
        .services .icon-box .icon i {
            color: #3b8af2;
            font-size: 28px;
            transition: ease-in-out 0.3s;
        }
        .services .icon-box h4 {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 24px;
        }
        .services .icon-box h4 a {
            color: #222222;
            transition: ease-in-out 0.3s;
        }
        .services .icon-box p {
            line-height: 24px;
            font-size: 14px;
            margin-bottom: 0;
        }

        .testimonials {
            padding: 80px 0;
            background: url('/images/one/testimonials-bg.jpg') no-repeat;
            background-position: center center;
            background-size: cover;
            position: relative;
        }
        .testimonials::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
        }
        .testimonials .testimonial-item {
            text-align: center;
            color: #fff;
        }
        .testimonials .testimonial-item .testimonial-img {
            width: 100px;
            border-radius: 50%;
            border: 6px solid rgba(255, 255, 255, 0.15);
            margin: 0 auto;
        }
        .testimonials .testimonial-item h3 {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0 5px 0;
            color: #fff;
        }
        .testimonials .testimonial-item h4 {
            font-size: 14px;
            color: #ddd;
            margin: 0 0 15px 0;
        }
        .testimonials .testimonial-item p {
            font-style: italic;
            margin: 0 auto 15px auto;
            color: #eee;
        }

        .testimonials .testimonial-item .quote-icon-left {
            display: inline-block;
            left: -5px;
            position: relative;
        }
        .testimonials .testimonial-item .quote-icon-right {
            display: inline-block;
            right: -5px;
            position: relative;
            top: 10px;
        }
        .testimonials .testimonial-item .quote-icon-left, .testimonials .testimonial-item .quote-icon-right {
            color: rgba(255, 255, 255, 0.4);
            font-size: 26px;
        }

        .portfolio #portfolio-flters {
            padding: 0;
            margin: 0 auto 15px auto;
            list-style: none;
            text-align: center;
            border-radius: 50px;
            padding: 2px 15px;
        }

        .about p {
            color: #2c2c2c;
        }

        .team {
            padding: 60px 0;
        }
        .team .member {
            margin-bottom: 20px;
            overflow: hidden;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0px 2px 15px rgb(16 110 234 / 15%);
        }
        .team .member .member-img {
            position: relative;
            overflow: hidden;
        }
        .team .member .social {
            position: absolute;
            left: 0;
            bottom: 30px;
            right: 0;
            opacity: 0;
            transition: ease-in-out 0.3s;
            text-align: center;
        }
        .team .member .social a {
            transition: color 0.3s;
            color: #222222;
            margin: 0 3px;
            padding-top: 7px;
            border-radius: 4px;
            width: 36px;
            height: 36px;
            background: rgba(16, 110, 234, 0.8);
            display: inline-block;
            transition: ease-in-out 0.3s;
            color: #fff;
        }
        .team .member .social i {
            font-size: 18px;
        }
        .team .member .member-info {
            padding: 25px 15px;
        }
        .team .member .member-info h4 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 18px;
            color: #222222;
        }
        .team .member .member-info h4 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 18px;
            color: #222222;
        }

        .contact .info-box {
            color: #444444;
            text-align: center;
            box-shadow: 0 0 30px rgb(214 215 216 / 30%);
            padding: 20px 0 30px 0;
        }
        .contact .info-box i {
            font-size: 32px;
            color: #106eea;
            border-radius: 50%;
            padding: 8px;
            border: 2px dotted #b3d1fa;
        }
        .contact .info-box h3 {
            font-size: 20px;
            color: #777777;
            font-weight: 700;
            margin: 10px 0;
        }
        .contact .info-box p {
            padding: 0;
            line-height: 24px;
            font-size: 14px;
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <h1>PT. SUPRA TIRTHA JAYA</h1>
            <h2>Terobosan Baru di Dunia Pengobatan Tradisional</h2>
            <div class="d-flex">
                <a href="/member/login" class="btn-get-started scrollto">Member Login</a>
                <a href="https://youtu.be/WoAXea8Mg5Q" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
            </div>
        </div>
    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Featured Services Section ======= -->
        <section id="featured-services" class="featured-services">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4 class="title"><a href="">Produk Asli Indonesia</a></h4>
                            <p class="description">Produk-produk dari STJ dibuat oleh Putera Asli Bali dan terbuat dari bahan pilihan khas Indonesia untuk memajukan dan mensejahterakan masyarakat lokal khususnya pelaku usaha / UMKM</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="">Menghemat Waktu & Biaya</a></h4>
                            <p class="description">Sebuah metode pengobatan tradisional yang dikemas secara praktis dan dapat membantu Anda mengatasi berbagai macam keluhan tanpa harus menghabiskan waktu & biaya besar untuk pergi ke klink / dokter</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4 class="title"><a href="">Terbuat Dari Bahan Alami</a></h4>
                            <p class="description">Awan (Lengis Taksu) Herbal Oil sebagai warisan budaya nenek moyang, diracik lebih dari 70 macam formula rempah-rempah hasil tanaman masyarakat lokal untuk menjadi sebuah produk minyak balur yang luar biasa. sehingga hasilnya aman tanpa efek samping</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Featured Services Section -->

        <!-- ======= About Section ======= -->
        <section id="about" class="about section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>About</h2>
                    <h3>Find Out More <span>About Us</span></h3>
                    <p>
                        PT. SUPRA TIRTHA JAYA didirikan pada tanggal 8 Desember 2018 oleh Direktur Utama (Owner) Putu Juni Ambara sebagai perusahaan yang bergerak dibidang importir, produksi dan distribusi produk unggulan dengan konsep network marketing.
                        <br /><br />
                        PT. SUPRA TIRTHA JAYA yang beralamat di Jl. Hasanuddin No 59 Gedung Darma Lantai 2 Pemecutan Denpasar sudah terdaftar dengan Ijin NIB, Ijin Usaha serta Ijin Lokasi dengan No. 9120101111857.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <img src="/images/one/about.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
                        <h3>Produk STJ Bali Sudah Banyak Dipakai dan Terbukti Bermanfaat untuk Masyarakat Indonesia.</h3>
                        <p class="fst-italic">
                            Ayo Cintai Produk Asli Indonesia dan Lestarikan Budaya Leluhur dengan Beralih ke Produk Pengobatan Tradisional yang Praktis, Terbukti Ampuh, dan Banyak Manfaatnya dari STJ.
                        </p>
                        <ul>
                            <li>
                                <i class="bx bx-store-alt"></i>
                                <div>
                                    <h5>Tentang Kami</h5>
                                    <p>Beridiri Sejak 2018, PT. STJ Tak Berhenti Bergerak dan Terus Menghadirkan Inovasi Dari Karya-Karya Asli Bali Lainnya..
                                        Hingga saat ini, PT. STJ Telah Memiliki 2 Macam Produk Unggulan Pengobatan Tradisional</p>
                                </div>
                            </li>
                            <li>
                                <i class="bx bx-images"></i>
                                <div>
                                    <h5>Warisan Budaya Nenek Moyang</h5>
                                    <p>Salah satu Warisan Budaya Nenek Moyang yang hampir punah adalah pengobatan tradisional.</p>
                                </div>
                            </li>
                        </ul>
                        <p>
                            April 2020, dalam terpaan pandemi, STJ melakukan berbagai terobosan. Salah satunya kreasi minyak balur yang memiliki banyak manfaat kesehatan. Besar harapan STJ menggerakkan ekonomi Indonesia, khususnya Bali, di tengah kelesuan dunia pariwisata sehingga maju bersama-sama menggapai kemerdekaan finansial bagi anggota-anggotanya.
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container" data-aos="zoom-in">

                <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="/images/one/testimonials-1.jpg" class="testimonial-img" alt="">
                                <h3>Saul Goodman</h3>
                                <h4>Ceo &amp; Founder</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="/images/one/testimonials-2.jpg" class="testimonial-img" alt="">
                                <h3>Sara Wilsson</h3>
                                <h4>Designer</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="/images/one/testimonials-3.jpg" class="testimonial-img" alt="">
                                <h3>Jena Karlis</h3>
                                <h4>Store Owner</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="/images/one/testimonials-4.jpg" class="testimonial-img" alt="">
                                <h3>Matt Brandon</h3>
                                <h4>Freelancer</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="/images/one/testimonials-5.jpg" class="testimonial-img" alt="">
                                <h3>John Larson</h3>
                                <h4>Entrepreneur</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div><!-- End testimonial item -->

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section><!-- End Testimonials Section -->

        <!-- ======= Team Section ======= -->
        <section id="team" class="team section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Team</h2>
                    <h3>Our Hardworking <span>Team</span></h3>
                    <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
                </div>

                <div class="row">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="member">
                            <div class="member-img">
                                <img src="/images/one/team-1.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Walter White</h4>
                                <span>Chief Executive Officer</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
                        <div class="member">
                            <div class="member-img">
                                <img src="/images/one/team-2.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Sarah Jhonson</h4>
                                <span>Product Manager</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
                        <div class="member">
                            <div class="member-img">
                                <img src="/images/one/team-3.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>William Anderson</h4>
                                <span>CTO</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
                        <div class="member">
                            <div class="member-img">
                                <img src="/images/one/team-4.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-twitter"></i></a>
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Amanda Jepson</h4>
                                <span>Accountant</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Team Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <h3><span>Contact Us</span></h3>
                    <p>Konsultasi / Pesan langsung Produk-Produk STJ dengan menghubungi Admin kami via WA : +628113924555</p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>Jl. Hasanuddin No 59 Gedung Darma Lantai 2 Pemecutan Denpasar</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p><a href="mailto:supratirthajaya@gmail.com">supratirthajaya@gmail.com</a></p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>+62 361 9070612</p>
                        </div>
                    </div>

                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">

                    <div class="col-lg-6 ">
                        <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.344485011068!2d115.21024361478395!3d-8.658750293778274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd24105cdb08319%3A0xed58976a339faa5d!2sPT.%20Supra%20Tirtha%20Jaya!5e0!3m2!1sen!2sid!4v1617684928054!5m2!1sen!2sid" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
                    </div>

                    <div class="col-lg-6">
                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="col form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                                </div>
                                <div class="col form-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit" disabled>Send Message</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
@endsection

@section('page-script')
    <script src="{{ asset(mix('js/scripts/aos/aos.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/glightbox/glightbox.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/swiper/swiper-bundle.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/single.js')) }}"></script>
@endsection
