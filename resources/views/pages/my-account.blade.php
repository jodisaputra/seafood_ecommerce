@extends('layouts.frontend')
@section('title', 'Seafood | My Account')
@section('content')
    <div class="container pt-5 pb-5">
        <h1 class="mb-4">My Transaction</h1>
        <div class="row">
            <div class="col-12">
                @forelse ($invoices as $invoice)
                    <div class="card mb-4">
                        <div class="card-header">#{{ $invoice->invoice_code }}</div>
                        <div class="card-body">
                            <address>
                                Alamat :
                                {{ $invoice->full_address }}
                            </address>
                            <ul>
                                @foreach ($invoice->orders as $order)
                                    <li>{{ $order->product_name . ' x ' . $order->qty }} = @currency($order->price * $order->qty)</li>
                                @endforeach
                            </ul>
                            <b>Total = @currency($invoice->grand_total)</b>
                            <br>
                            <br>
                            <p><b>Status Payment = {{ ucfirst($invoice->status) }}</b></p>
                            <p><b>Pengiriman =
                                    @if ($invoice->delivery_status == 'ongoing')
                                        Ongoing
                                    @elseif ($invoice->delivery_status == 'on_delivery')
                                        On Delivery
                                    @else
                                        Complete
                                    @endif
                                </b>
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body text-center">Tidak Ada Transaksi !</div>
                    </div>
                @endforelse
                {{ $invoices->links() }}
            </div>


        </div>
    </div>
@endsection
