@extends('layouts.frontend')
@section('title', 'Seafood | Detail Product')
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-6">
                    <!-- PRODUCT SLIDER-->
                    <div class="row m-sm-0">
                        <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                            <div class="swiper product-slider-thumbs">
                                <div class="swiper-wrapper">
                                    @foreach ($product->gallery as $item)
                                        <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100"
                                                src="{{ $item->image }}" alt="..."></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-10 order-1 order-sm-2">
                            <div class="swiper product-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($product->gallery as $item)
                                        <div class="swiper-slide h-auto"><a class="glightbox product-view"
                                                href="{{ $item->image }}" data-gallery="gallery2"
                                                data-glightbox="{{ $product->title }}"><img class="img-fluid"
                                                    src="{{ $item->image }}" alt="..."></a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <h1>{{ $product->title }}</h1>
                    <p class="text-muted lead">@currency($product->price)</p>
                    <div class="row align-items-stretch mb-4">
                        <div class="col-sm-5 pr-sm-0">
                            <div
                                class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                                <span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                                <div class="quantity">
                                    <input class="form-control border-0 shadow-0 p-0" type="number" min="1" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 pl-sm-0"><a
                                class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0"
                                href="">Add to cart</a></div>
                        <ul class="list-unstyled small d-inline-block">
                            <li class="px-3 py-2 mb-1 bg-white text-muted"><strong
                                    class="text-uppercase text-dark">Category:</strong><a class="reset-anchor ms-2"
                                    href="{{ route('find_product_by_category', $product->category->slug) }}">{{ strtoupper($product->category->name) }}</a>
                            </li>
                            <li class="px-3 py-2 mb-1 bg-white text-muted">
                        </ul>
                    </div>
                </div>
                <!-- DETAILS TABS-->
                <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab"
                            href="#description" role="tab" aria-controls="description"
                            aria-selected="true">Description</a>
                    </li>
                </ul>
                <div class="tab-content mb-5" id="myTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                        aria-labelledby="description-tab">
                        <div class="p-4 p-lg-5 bg-white">
                            <h6 class="text-uppercase">Product description </h6>
                            <p class="text-muted text-sm mb-0">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection
