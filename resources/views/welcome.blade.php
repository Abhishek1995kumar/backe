<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title class="text-uppercase"> {{ config('app-name.fname')}} {{ config('app-name.lname')}} </title>
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{asset('admin_assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin_assets/css/templatemo-villa-agency.css')}}">

</head>

<body class="antialiased">
    <header class="header-area header-sticky">
        <div class="container" style="padding-right: calc(var(--bs-gutter-x)* 2);">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="#" class="logo">
                            <div class="d-flex mt-4">
                                <h4 class="text-uppercase"> {{ config('app-name.fname')}} </h4>
                            </div>
                        </a>
                    </div> 
                        <ul class="col-lg-12 nav">
                            <li class=""><a href="#" class="active"><i class="fa fa-home"></i>Home</a></li>
                            <li class=""><a href="#"><i class="fa-brands fa-servicestack"></i>Servies</a></li>
                            <li class=""><a href="#"><i class="fa-solid fa-industry"></i>Industries</a></li>
                            <li class=""><a href="#"><i class="fa-solid fa-address-card"></i>About Us</a></li>
                            <li class=""><a href="#"><i class="fa-solid fa-scarecrow"></i>Careers</a></li>
                            <li class=""><a href="#"><i class="fa-solid fa-phone"></i>Contact</a></li>
                            <li class="">
                                <div class="d-flex justify-content-between sm:fixed sm:top-0 sm:right-0 p-6 text-right">

                                    <a href="{{ url('/user') }}" style="background-color:#0000;color:#000000;"><i class="fa-solid fa-user"></i>User</a>

                                    <a href="{{ url('vendor/welcome') }}" style="background-color:#0000;color:#000000;"><i class="fa-solid fa-user"></i>Seller</a>

                                </div>
                            </li>
                        </ul>
                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="main-banner">
            <div class="owl-carousel owl-banner">
                <div class="item item-1">
                    <div class="header-text">
                        <span class="category">New Delhi, <em>Bharat</em></span>
                        <h2>Hurry!<br>Get the Best House for you</h2>
                    </div>
                </div>
                <div class="item item-2">
                    <div class="header-text">
                        <span class="category">Lucknow, <em>Bharat</em></span>
                        <h2>Be Quick!<br>Get the best villa in town</h2>
                    </div>
                </div>
                <div class="item item-3">
                    <div class="header-text">
                        <span class="category">Miami, <em>South Florida</em></span>
                        <h2>Act Now!<br>Get the highest level house</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="video section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 offset-lg-4">
                        <div class="section-heading text-center">
                            <h6>| Video View</h6>
                            <h2>Get Closer View & Different Feeling</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="video-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="video-frame">
                            <img src="assets/images/video-frame.jpg" alt="">
                            <a href="https://youtube.com" target="_blank"><i class="fa fa-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 offset-lg-4">
                        <div class="section-heading text-center">
                            <h6>| Contact Us</h6>
                            <h2>Get In Touch With Our Agents</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="contact-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div id="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12469.776493332698!2d-80.14036379941481!3d25.907788681148624!2m3!1f357.26927939317244!2f20.870722720054623!3f0!3m2!1i1024!2i768!4f35!3m3!1m2!1s0x88d9add4b4ac788f%3A0xe77469d09480fcdb!2sSunny%20Isles%20Beach!5e1!3m2!1sen!2sth!4v1642869952544!5m2!1sen!2sth" width="100%" height="500px" frameborder="0" style="border:0; border-radius: 10px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);" allowfullscreen=""></iframe>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="item phone">
                                    <img src="assets/images/phone-icon.png" alt="" style="max-width: 52px;">
                                    <h6>9415058209<br><span>Contact </span></h6>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="item email">
                                    <img src="assets/images/email-icon.png" alt="" style="max-width: 52px;">
                                    <h6>annaaryan95@gmail.com<br><span>Business Email</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <form id="contact-form" action="" method="post">
                            <div class="row">
                                <div class="col-lg-12">
                                    <fieldset>
                                        <label for="name">Full Name</label>
                                        <input type="name" name="name" id="name" placeholder="Your Name..." autocomplete="on" required>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <label for="email">Email Address</label>
                                        <input type="text" name="email" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your E-mail..." required="">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <label for="subject">Subject</label>
                                        <input type="subject" name="subject" id="subject" placeholder="Subject..." autocomplete="on">
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <label for="message">Message</label>
                                        <textarea name="message" id="message" placeholder="Your Message"></textarea>
                                    </fieldset>
                                </div>
                                <div class="col-lg-12">
                                    <fieldset>
                                        <button type="submit" id="form-submit" class="orange-button">Send Message</button>
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer>
        <div class="col-lg-12">
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">

            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{asset('admin_assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/isotope.min.js')}}"></script>
    <script src="{{asset('admin_assets/js/owl-carousel.js')}}"></script>
    <script src="{{asset('admin_assets/js/counter.js')}}"></script>
    <script src="{{asset('admin_assets/js/custom.js')}}"></script>

</body>

</html>