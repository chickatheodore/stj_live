@extends('layouts/homeLayoutMaster')

@section('title', 'Home')

@section('page-style')
    {{-- Page Css files --}}
    <style type="text/css">
        .horizontal-menu.navbar-sticky .horizontal-menu-wrapper .navbar-horizontal.header-navbar.fixed-top {
            top: 0px;
        }
        /*@media (min-width: 1024px) {
            #hero {
                background-attachment: fixed;
            }
        }

        @media (max-width: 768px) {
            #hero {
                height: 100vh;
            }
        }*/

        #hero {
            width: 100%;
            height: 75vh;
            background: url(../img/hero-bg.jpg) top left;
            background-size: cover;
            position: relative;
        }

        #hero .container {
            position: relative;
        }

        /*[data-aos][data-aos][data-aos-delay="100"].aos-animate, body[data-aos-delay="100"] [data-aos].aos-animate {
            transition-delay: .1s;
        }
        [data-aos^=zoom][data-aos^=zoom].aos-animate {
            opacity: 1;
            transform: translateZ(0) scale(1);
        }
        [data-aos][data-aos][data-aos-delay="100"], body[data-aos-delay="100"] [data-aos] {
            transition-delay: 0;
        }
        [data-aos][data-aos][data-aos-easing=ease-in-out], body[data-aos-easing=ease-in-out] [data-aos] {
            transition-timing-function: ease-in-out;
        }
        [data-aos][data-aos][data-aos-duration="1000"], body[data-aos-duration="1000"] [data-aos] {
            transition-duration: 1s;
        }
        [data-aos^=zoom][data-aos^=zoom] {
            opacity: 0;
            transition-property: opacity,transform;
        }

        [data-aos=zoom-out] {
            transform: scale(1.2);
        }
        [data-aos^=fade][data-aos^=fade].aos-animate {
            opacity: 1;
            transform: translateZ(0);
        }
        [data-aos^=fade][data-aos^=fade] {
            opacity: 0;
            transition-property: opacity,transform;
        }*/

        /*@media (min-width: 1400px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                max-width: 1320px;
            }
        }
        @media (min-width: 1200px) {
            .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 1140px;
            }
        }
        @media (min-width: 992px) {
            .container, .container-lg, .container-md, .container-sm {
                max-width: 960px;
            }
        }
        @media (min-width: 768px) {
            .container, .container-md, .container-sm {
                max-width: 720px;
            }
        }
        @media (min-width: 576px) {
            .container, .container-sm {
                max-width: 540px;
            }
        }
        .container, .container-fluid, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
            width: 100%;
            padding-right: var(--bs-gutter-x,.75rem);
            padding-left: var(--bs-gutter-x,.75rem);
            margin-right: auto;
            margin-left: auto;
        }*/

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

        /*.section-bg {
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
        }*/
        /*@media (min-width: 1024px) {
            .section-title p {
                width: 50%;
            }
        }*/

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
            background: url(../img/testimonials-bg.jpg) no-repeat;
            background-position: center center;
            background-size: cover;
            position: relative;
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
        /*@media (min-width: 992px) {
            .testimonials .testimonial-item p {
                width: 80%;
            }
        }*/

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
            <h1>Welcome to <span>BizLand</span></h1>
            <h2>We are team of talented designers making websites with Bootstrap</h2>
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
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="bx bxl-dribbble"></i></div>
                            <h4 class="title"><a href="">Lorem Ipsum</a></h4>
                            <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="">Sed ut perspiciatis</a></h4>
                            <p class="description">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon"><i class="bx bx-tachometer"></i></div>
                            <h4 class="title"><a href="">Magni Dolores</a></h4>
                            <p class="description">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="bx bx-world"></i></div>
                            <h4 class="title"><a href="">Nemo Enim</a></h4>
                            <p class="description">At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
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
                    <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
                </div>

                <div class="row">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <img src="assets/img/about.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
                        <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                            magna aliqua.
                        </p>
                        <ul>
                            <li>
                                <i class="bx bx-store-alt"></i>
                                <div>
                                    <h5>Ullamco laboris nisi ut aliquip consequat</h5>
                                    <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
                                </div>
                            </li>
                            <li>
                                <i class="bx bx-images"></i>
                                <div>
                                    <h5>Magnam soluta odio exercitationem reprehenderi</h5>
                                    <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
                                </div>
                            </li>
                        </ul>
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                            culpa qui officia deserunt mollit anim id est laborum
                        </p>
                    </div>
                </div>

            </div>
        </section><!-- End About Section -->

        <!-- ======= Counts Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-3 col-md-6">
                        <div class="count-box">
                            <i class="bi bi-emoji-smile"></i>
                            <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Happy Clients</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                        <div class="count-box">
                            <i class="bi bi-journal-richtext"></i>
                            <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Projects</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-headset"></i>
                            <span data-purecounter-start="0" data-purecounter-end="1463" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hours Of Support</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                        <div class="count-box">
                            <i class="bi bi-people"></i>
                            <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Hard Workers</p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Counts Section -->

        <!-- ======= Testimonials Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container" data-aos="zoom-in">

                <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
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
                                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
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
                                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
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
                                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
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
                                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
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
                                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
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
                                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
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
                                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
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
                                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
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
                    <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6">
                        <div class="info-box mb-4">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>A108 Adam Street, New York, NY 535022</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p><a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="1f7c70716b7e7c6b5f7a677e726f737a317c7072">[email&#160;protected]</a></p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="info-box  mb-4">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>+1 5589 55488 55</p>
                        </div>
                    </div>

                </div>

                <div class="row" data-aos="fade-up" data-aos-delay="100">

                    <div class="col-lg-6 ">
                        <iframe class="mb-4 mb-lg-0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0; width: 100%; height: 384px;" allowfullscreen></iframe>
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
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->
@endsection
