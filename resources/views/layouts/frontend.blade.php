<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    @include('includes/frontend/styles')
</head>

<body>
    <div class="page-holder">
        <!-- navbar-->
        <header class="header bg-white">
            <div class="container px-lg-3">
                <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand"
                        href="{{ route('default') }}"><span class="fw-bold text-uppercase text-dark">Boutique</span></a>
                    <button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <!-- Link--><a class="nav-link active" href="{{ route('default') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <!-- Link--><a class="nav-link" href="{{ route('find_product_by_category') }}">Shop</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto">
                            @guest('customer')
                                @php
                                    $cart = 0;
                                @endphp
                            @endguest
                            @auth('customer')
                                @php
                                    $cart = \App\Models\Cart::where('customer_id', Auth::guard('customer')->user()->id)
                                        ->get()
                                        ->count();
                                @endphp
                            @endauth
                            <li class="nav-item"><a class="nav-link" href="{{ route('product.shop.cart') }}">
                                    <i class="fas fa-dolly-flatbed me-1 text-gray"></i>Cart<small
                                        class="text-gray fw-normal">({{ $cart }})</small></a>
                            </li>
                            {{-- <li class="nav-item"><a class="nav-link" href="#!"> <i
                                        class="far fa-heart me-1"></i><small class="text-gray fw-normal">
                                        (0)</small></a></li> --}}
                            @guest('customer')
                                <li class="nav-item"><a class="nav-link" href="{{ route('customer.loginview') }}"><i
                                            class="fas fa-user me-1 text-gray fw-normal"></i>Login</a></li>
                            @endguest
                            @auth('customer')
                                <li class="nav-item"><a class="nav-link" href="#!"><i
                                            class="fas fa-user me-1 text-gray fw-normal"></i>{{ Auth::guard('customer')->user()->name }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                                 document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                        <input type="hidden" name="type" value="user">
                                    </form>
                                </li>
                            @endauth
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- HERO SECTION-->
        @include('sweetalert::alert')
        <div class="container">
            @yield('content')
        </div>
        <footer class="bg-dark text-white">
            <div class="container py-4">
                <div class="row py-5">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h6 class="text-uppercase mb-3">Customer services</h6>
                        <ul class="list-unstyled mb-0">
                            <li><a class="footer-link" href="#!">Help &amp; Contact Us</a></li>
                            <li><a class="footer-link" href="#!">Returns &amp; Refunds</a></li>
                            <li><a class="footer-link" href="#!">Online Stores</a></li>
                            <li><a class="footer-link" href="#!">Terms &amp; Conditions</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <h6 class="text-uppercase mb-3">Company</h6>
                        <ul class="list-unstyled mb-0">
                            <li><a class="footer-link" href="#!">What We Do</a></li>
                            <li><a class="footer-link" href="#!">Available Services</a></li>
                            <li><a class="footer-link" href="#!">Latest Posts</a></li>
                            <li><a class="footer-link" href="#!">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-uppercase mb-3">Social media</h6>
                        <ul class="list-unstyled mb-0">
                            <li><a class="footer-link" href="#!">Twitter</a></li>
                            <li><a class="footer-link" href="#!">Instagram</a></li>
                            <li><a class="footer-link" href="#!">Tumblr</a></li>
                            <li><a class="footer-link" href="#!">Pinterest</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-top pt-4" style="border-color: #1d1d1d !important">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <p class="small text-muted mb-0">&copy; 2021 All rights reserved.</p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <p class="small text-muted mb-0">Template designed by <a class="text-white reset-anchor"
                                    href="https://bootstrapious.com/p/boutique-bootstrap-e-commerce-template">Bootstrapious</a>
                            </p>
                            <!-- If you want to remove the backlink, please purchase the Attribution-Free License. See details in readme.txt or license.txt. Thanks!-->
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        @include('includes/frontend/scripts')
        @stack('scripts')
    </div>
</body>

</html>
