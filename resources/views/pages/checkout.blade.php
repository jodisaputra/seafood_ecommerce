@extends('layouts.frontend')
@section('title', 'Seafood | Checkout')
@section('content')
    <div class="container">
        <!-- HERO SECTION-->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-6">
                        <h1 class="h2 text-uppercase mb-0">Checkout</h1>
                    </div>
                    <div class="col-lg-6 text-lg-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
                                <li class="breadcrumb-item"><a class="text-dark" href="{{ route('default') }}">Home</a></li>
                                <li class="breadcrumb-item"><a class="text-dark"
                                        href="{{ route('product.shop.cart') }}">Cart</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <!-- BILLING ADDRESS-->
            <h2 class="h5 text-uppercase mb-4">Billing details</h2>
            <div class="row">
                <div class="col-lg-8">
                    <form action="#" id="form-checkout">
                        <div class="row gy-3">
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase" for="name">FullName </label>
                                <input class="form-control form-control-lg" type="text" id="name"
                                    placeholder="Enter your fullname" name="name" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase" for="phone">Phone number </label>
                                <input class="form-control form-control-lg" type="text" id="phone" name="phone"
                                    placeholder="e.g. +02 245354745" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label text-sm text-uppercase" for="full_address">Full Address</label>
                                <input class="form-control form-control-lg" type="text" id="full_address"
                                    name="full_address" placeholder="Apartment, Suite, Unit, etc (optional)" required>
                            </div>
                            <input type="hidden" value="{{ $total }}" name="grand_total" id="grand_total">
                            <input type="hidden" value="{{ Auth::guard('customer')->user()->id }}" name="customer_id" id="customer_id">
                            <input type="hidden" value="{{ Auth::guard('customer')->user()->email }}" name="email" id="email">
                            <div class="col-lg-12 form-group">
                                <button class="btn btn-dark" type="submit">Place order</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ORDER SUMMARY-->
                <div class="col-lg-4">
                    <div class="card border-0 rounded-0 p-lg-4 bg-light">
                        <div class="card-body">
                            <h5 class="text-uppercase mb-4">Your order</h5>
                            <ul class="list-unstyled mb-0">
                                @forelse ($carts as $item)
                                    <li class="d-flex align-items-center justify-content-between"><strong
                                            class="small fw-bold">{{ ucfirst($item->product->title) }} x
                                            {{ $item->qty }}</strong><span
                                            class="text-muted small">@currency($item->price)</span></li>
                                    <li class="border-bottom my-2"></li>
                                @empty
                                    <li class="d-flex align-items-center justify-content-between"><strong
                                            class="small fw-bold">Tidak ada Produk !</strong>
                                    </li>
                                @endforelse
                                <li class="d-flex align-items-center justify-content-between"><strong
                                        class="text-uppercase small fw-bold">Total</strong><span>@currency($total)</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <script>
        $('#form-checkout').submit(function(event) {
            event.preventDefault();
            $.post("/api/checkout", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                phone: $('#phone').val(),
                full_address: $('#full_address').val(),
                grand_total: $('#grand_total').val(),
                customer_id: $('#customer_id').val()
            }, function(data, status) {
                snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        location.reload();
                    },
                    onPending: function(result) {
                        location.reload();
                    },
                    onError: function(result) {
                        location.reload();
                    }
                });
                return false;
            })
        })
    </script>
@endpush
