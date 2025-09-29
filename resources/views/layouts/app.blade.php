<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/swiper.min.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header id="header" class="header header-fullwidth header-transparent-bg">
            <div class="container">
                <div class="header-desk header-desk_type_1">
                    <div class="logo">
                        <a href="{{route('home.index')}}">
                            <img src="{{asset('assets/images/logo.png')}}" alt="Uomo" class="logo__image d-block" />
                        </a>
                    </div>

                    <nav class="navigation">
                        <ul class="navigation__list list-unstyled d-flex">
                            <li class="navigation__item">
                                <a href="{{route('home.index')}}" class="navigation__link">Home</a>
                            </li>
                            <li class="navigation__item">
                                <a href="shop.html" class="navigation__link">Shop</a>
                            </li>
                            <li class="navigation__item">
                                <a href="cart.html" class="navigation__link">Cart</a>
                            </li>
                            <li class="navigation__item">
                                <a href="about.html" class="navigation__link">About</a>
                            </li>
                            <li class="navigation__item">
                                <a href="contact.html" class="navigation__link">Contact</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="header-tools d-flex align-items-center">
                        <div class="header-tools__item hover-container">
                            <div class="js-hover__open position-relative">
                                <a class="js-search-popup search-field__actor" href="#">
                                    <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_search" />
                                    </svg>
                                    <i class="btn-icon btn-close-lg"></i>
                                </a>
                            </div>

                            <div class="search-popup js-hidden-content">
                                <form action="#" method="GET" class="search-field container">
                                    <p class="text-uppercase text-secondary fw-medium mb-4">What are you looking for?
                                    </p>
                                    <div class="position-relative">
                                        <input class="search-field__input search-popup__input w-100 fw-medium"
                                            type="text" name="search-keyword" placeholder="Search products" />
                                        <button class="btn-icon search-popup__submit" type="submit">
                                            <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <use href="#icon_search" />
                                            </svg>
                                        </button>
                                        <button class="btn-icon btn-close-lg search-popup__reset" type="reset"></button>
                                    </div>

                                    <div class="search-popup__results">
                                        <div class="sub-menu search-suggestion">
                                            <h6 class="sub-menu__title fs-base">Quicklinks</h6>
                                            <ul class="sub-menu__list list-unstyled">
                                                <li class="sub-menu__item"><a href="shop2.html"
                                                        class="menu-link menu-link_us-s">New Arrivals</a>
                                                </li>
                                                <li class="sub-menu__item"><a href="#"
                                                        class="menu-link menu-link_us-s">Dresses</a></li>
                                                <li class="sub-menu__item"><a href="shop3.html"
                                                        class="menu-link menu-link_us-s">Accessories</a>
                                                </li>
                                                <li class="sub-menu__item"><a href="#"
                                                        class="menu-link menu-link_us-s">Footwear</a></li>
                                                <li class="sub-menu__item"><a href="#"
                                                        class="menu-link menu-link_us-s">Sweatshirt</a></li>
                                            </ul>
                                        </div>

                                        <div class="search-result row row-cols-5"></div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @guest
                        <div class="header-tools__item hover-container">
                            <a href="{{route('login')}}" class="header-tools__item">
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_user" />
                                </svg>
                            </a>
                        </div>
                        @else
                        <div class="header-tools__item hover-container">
                            <a href="{{Auth::user()->utype === 'ADM' ? route('admin.index') : route('user.index')}}"
                                class="header-tools__item">
                                <span class="pr-6px">{{Auth::user()->name}}</span>
                                <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_user" />
                                </svg>
                            </a>
                        </div>
                        @endguest

                        <a href="wishlist.html" class="header-tools__item">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_heart" />
                            </svg>
                        </a>

                        <a href="cart.html" class="header-tools__item header-tools__cart">
                            <svg class="d-block" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_cart" />
                            </svg>
                            <span class="cart-amount d-block position-absolute js-cart-items-count">3</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        @yield('content')

        <hr class="mt-5 text-secondary" />
        <footer class="footer footer_type_2">
            <div class="footer-middle container">
                <div class="row row-cols-lg-5 row-cols-2">
                    <div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
                        <div class="logo">
                            <a href="{{route('home.index')}}">
                                <img src="assets/images/logo.png" alt="SurfsideMedia" class="logo__image d-block" />
                            </a>
                        </div>
                        <p class="footer-address">123 Beach Avenue, Surfside City, CA 00000</p>
                        <p class="m-0"><strong class="fw-medium">contact@surfsidemedia.in</strong></p>
                        <p><strong class="fw-medium">+1 000-000-0000</strong></p>

                        <ul class="social-links list-unstyled d-flex flex-wrap mb-0">
                            <li>
                                <a href="#" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_facebook" width="9" height="15" viewBox="0 0 9 15"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_facebook" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_twitter" width="14" height="13" viewBox="0 0 14 13"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_twitter" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_instagram" width="14" height="13" viewBox="0 0 14 13"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_instagram" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_youtube" width="16" height="11" viewBox="0 0 16 11"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.0117 1.8584C14.8477 1.20215 14.3281 0.682617 13.6992 0.518555C12.5234 0.19043 7.875 0.19043 7.875 0.19043C7.875 0.19043 3.19922 0.19043 2.02344 0.518555C1.39453 0.682617 0.875 1.20215 0.710938 1.8584C0.382812 3.00684 0.382812 5.46777 0.382812 5.46777C0.382812 5.46777 0.382812 7.90137 0.710938 9.07715C0.875 9.7334 1.39453 10.2256 2.02344 10.3896C3.19922 10.6904 7.875 10.6904 7.875 10.6904C7.875 10.6904 12.5234 10.6904 13.6992 10.3896C14.3281 10.2256 14.8477 9.7334 15.0117 9.07715C15.3398 7.90137 15.3398 5.46777 15.3398 5.46777C15.3398 5.46777 15.3398 3.00684 15.0117 1.8584ZM6.34375 7.68262V3.25293L10.2266 5.46777L6.34375 7.68262Z" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="footer__social-link d-block">
                                    <svg class="svg-icon svg-icon_pinterest" width="14" height="15" viewBox="0 0 14 15"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <use href="#icon_pinterest" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer-column footer-menu mb-4 mb-lg-0">
                        <h6 class="sub-menu__title text-uppercase">Company</h6>
                        <ul class="sub-menu__list list-unstyled">
                            <li class="sub-menu__item"><a href="about-2.html" class="menu-link menu-link_us-s">About
                                    Us</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Careers</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Affiliates</a></li>
                            <li class="sub-menu__item"><a href="blog_list1.html"
                                    class="menu-link menu-link_us-s">Blog</a></li>
                            <li class="sub-menu__item"><a href="contact-2.html" class="menu-link menu-link_us-s">Contact
                                    Us</a>
                            </li>
                        </ul>
                    </div>

                    <div class="footer-column footer-menu mb-4 mb-lg-0">
                        <h6 class="sub-menu__title text-uppercase">Shop</h6>
                        <ul class="sub-menu__list list-unstyled">
                            <li class="sub-menu__item"><a href="shop2.html" class="menu-link menu-link_us-s">New
                                    Arrivals</a>
                            </li>
                            <li class="sub-menu__item"><a href="shop3.html"
                                    class="menu-link menu-link_us-s">Accessories</a>
                            </li>
                            <li class="sub-menu__item"><a href="shop4.html" class="menu-link menu-link_us-s">Men</a>
                            </li>
                            <li class="sub-menu__item"><a href="shop5.html" class="menu-link menu-link_us-s">Women</a>
                            </li>
                            <li class="sub-menu__item"><a href="shop1.html" class="menu-link menu-link_us-s">Shop
                                    All</a></li>
                        </ul>
                    </div>

                    <div class="footer-column footer-menu mb-4 mb-lg-0">
                        <h6 class="sub-menu__title text-uppercase">Help</h6>
                        <ul class="sub-menu__list list-unstyled">
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Customer Service</a>
                            </li>
                            <li class="sub-menu__item"><a href="account_dashboard.html"
                                    class="menu-link menu-link_us-s">My
                                    Account</a>
                            </li>
                            <li class="sub-menu__item"><a href="store_location.html"
                                    class="menu-link menu-link_us-s">Find a
                                    Store</a>
                            </li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Legal & Privacy</a>
                            </li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Gift Card</a></li>
                        </ul>
                    </div>

                    <div class="footer-column footer-menu mb-4 mb-lg-0">
                        <h6 class="sub-menu__title text-uppercase">Categories</h6>
                        <ul class="sub-menu__list list-unstyled">
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shirts</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Jeans</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shoes</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Bags</a></li>
                            <li class="sub-menu__item"><a href="#" class="menu-link menu-link_us-s">Shop All</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="container d-md-flex align-items-center">
                    <span class="footer-copyright me-auto">©2024 Surfside Media</span>
                    <div class="footer-settings d-md-flex align-items-center">
                        <a href="privacy-policy.html">Privacy Policy</a> &nbsp;|&nbsp; <a
                            href="terms-conditions.html">Terms
                            &amp;
                            Conditions</a>
                    </div>
                </div>
            </div>
        </footer>


        <footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
            <div class="row text-center">
                <div class="col-4">
                    <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                        <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_home" />
                        </svg>
                        <span>Home</span>
                    </a>
                </div>

                <div class="col-4">
                    <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                        <svg class="d-block" width="18" height="18" viewBox="0 0 18 18" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_hanger" />
                        </svg>
                        <span>Shop</span>
                    </a>
                </div>

                <div class="col-4">
                    <a href="{{route('home.index')}}" class="footer-mobile__link d-flex flex-column align-items-center">
                        <div class="position-relative">
                            <svg class="d-block" width="18" height="18" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_heart" />
                            </svg>
                            <span class="wishlist-amount d-block position-absolute js-wishlist-count">3</span>
                        </div>
                        <span>Wishlist</span>
                    </a>
                </div>
            </div>
        </footer>

        <div id="scrollTop" class="visually-hidden end-0"></div>
        <div class="page-overlay"></div>

        <script src="{{asset('assets/js/plugins/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/bootstrap-slider.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/swiper.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins/countdown.js')}}"></script>
        <script src="{{asset('assets/js/theme.js')}}"></script>
    </div>
</body>

</html>
