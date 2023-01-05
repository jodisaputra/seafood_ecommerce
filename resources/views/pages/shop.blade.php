@extends('layouts.frontend')
@section('title', 'Seafood | Shop')
@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">Shop</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                            <li class="breadcrumb-item"><a class="text-dark" href="{{ route('default') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shop</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container p-0">
            <div class="row">
                <!-- SHOP SIDEBAR-->
                <div class="col-lg-3 order-2 order-lg-1">
                    <h5 class="text-uppercase mb-4">Categories</h5>
                    <ul class="list-unstyled small text-muted ps-lg-4 font-weight-normal">
                        @foreach ($category as $item)
                            <li class="mb-2"><a class="reset-anchor"
                                    href="{{ route('find_product_by_category', $item->slug) }}">{{ ucfirst($item->name) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- SHOP LISTING-->
                <div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                    <div class="row">
                        <!-- PRODUCT-->
                        @forelse ($product as $item)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product text-center">
                                    <div class="mb-3 position-relative">
                                        <div class="badge text-white bg-">
                                        </div>
                                        <a class="d-block" href="{{ route('product.shop.detail', $item->slug) }}">
                                            @if (count($item->gallery) > 0)
                                                <img class="img-fluid w-100" src="{{ $item->gallery[0]->image }}"
                                                    alt="{{ $item->title }}">
                                            @else
                                                <img class="img-fluid w-100"
                                                    src="{{ asset('frontend') }}/img/default-image.png"
                                                    alt="{{ $item->title }}">
                                            @endif
                                        </a>
                                        <div class="product-overlay">
                                            <ul class="mb-0 list-inline">
                                                <li class="list-inline-item m-0 p-0">
                                                    <form action="{{ route('cart.add', $item->slug) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-dark">Add to
                                                            cart</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <h6> <a class="reset-anchor"
                                            href="{{ route('product.shop.detail', $item->slug) }}">{{ ucfirst($item->title) }}</a>
                                    </h6>
                                    <p class="small text-muted">@currency($item->price)</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4 col-sm-6">
                                <div class="product text-center">
                                    <h5>Tidak ada Produk !</h5>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
