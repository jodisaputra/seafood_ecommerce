@extends('layouts.frontend')
@section('title', 'Seafood | Ecommerce')
@section('content')
    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center"
        style="background: url({{ asset('frontend/') }}/img/hero-banner-alt.jpg)">
        <div class="container py-5">
            <div class="row px-4 px-lg-5">
                <div class="col-lg-6">
                    <p class="text-muted small text-uppercase mb-2">New Inspiration 2020</p>
                    <h1 class="h2 text-uppercase mb-3">20% off on new season</h1>
                    {{-- <a class="btn btn-dark"
                        href="shop.html">Browse collections</a> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- CATEGORIES SECTION-->
    <section class="pt-5">
        <header class="text-center">
            <p class="small text-muted small text-uppercase mb-1">Carefully created collections</p>
            <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
        </header>
        <div class="row">
            @foreach ($category as $item)
                <div class="col-md-4">
                    <a class="category-item mb-4" href="{{ route('find_product_by_category', $item->slug) }}">
                        <img class="img-fluid"src="{{ $item->image }}" alt="{{ $item->name }}" />
                        <strong class="category-item-title">{{ $item->name }}</strong>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
    <!-- TRENDING PRODUCTS-->
    {{-- <section class="py-5">
        <header>
            <p class="small text-muted small text-uppercase mb-1">Made the hard way</p>
            <h2 class="h5 text-uppercase mb-4">Top trending products</h2>
        </header>
        <div class="row">
            <!-- PRODUCT-->
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="product text-center">
                    <div class="position-relative mb-3">
                        <div class="badge text-white bg-"></div><a class="d-block" href="detail.html"><img
                                class="img-fluid w-100" src="img/product-1.jpg" alt="..."></a>
                        <div class="product-overlay">
                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark"
                                        href="#!"><i class="far fa-heart"></i></a></li>
                                <li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="cart.html">Add to
                                        cart</a></li>
                                <li class="list-inline-item me-0"><a class="btn btn-sm btn-outline-dark" href="#productView"
                                        data-bs-toggle="modal"><i class="fas fa-expand"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <h6> <a class="reset-anchor" href="detail.html">Kui Ye Chen’s AirPods</a></h6>
                    <p class="small text-muted">$250</p>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- SERVICES-->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center gy-3">
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#delivery-time-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">Free shipping</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#helpline-24h-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">24 x 7 service</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="d-inline-block">
                        <div class="d-flex align-items-end">
                            <svg class="svg-icon svg-icon-big svg-icon-light">
                                <use xlink:href="#label-tag-1"> </use>
                            </svg>
                            <div class="text-start ms-3">
                                <h6 class="text-uppercase mb-1">Festivaloffers</h6>
                                <p class="text-sm mb-0 text-muted">Free shipping worldwide</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br>
@endsection
