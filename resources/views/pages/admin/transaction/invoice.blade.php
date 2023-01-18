@extends('layouts.app')
@section('title', 'Seafood | Transaction List')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
@endpush

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Invoice
                <strong>{{ $invoice->invoice_code }}</strong>
                <span class="float-right"> <strong>Payment Status:</strong> {{ ucfirst($invoice->status) }} <strong>
                        &nbsp;&nbsp;&nbsp; Delivery
                        Status:</strong>
                    @if ($invoice->delivery_status == 'ongoing')
                        Ongoing
                    @elseif ($invoice->delivery_status == 'on_delivery')
                        On Delivery
                    @else
                        Complete
                    @endif
                </span>

            </div>
            <div class="card-body">
                <div class="row mb-4">

                    <div class="col-sm-6">
                        <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>{{ $invoice->name }}</strong>
                        </div>
                        <div>Address: {{ $invoice->full_address }}</div>
                        <div>Email: {{ $invoice->customer->email }}</div>
                        <div>Phone: {{ $invoice->phone }}</div>
                    </div>



                </div>

                <div class="table-responsive-sm">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th>Item</th>

                                <th class="right">Unit Cost</th>
                                <th class="center">Qty</th>
                                <th class="right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoice->orders as $order)
                                <tr>
                                    <td class="center">{{ $loop->iteration }}</td>
                                    <td class="left strong">{{ $order->product_name }}</td>

                                    <td class="right">@currency($order->price)</td>
                                    <td class="center">{{ $order->qty }}</td>
                                    <td class="right">@currency($order->price * $order->qty)</td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-5">

                    </div>

                    <div class="col-lg-4 col-sm-5 ml-auto">
                        <table class="table table-clear">
                            <tbody>
                                <tr>
                                    <td class="left">
                                        <strong>Total</strong>
                                    </td>
                                    <td class="right">
                                        <strong>@currency($invoice->grand_total)</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="container mt-2 mb-2">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('transaction.update', $invoice->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="delivery_status">Delivery Status</label>
                        <select name="delivery_status" id="delivery_status" class="form-control">
                            <option value="ongoing" {{ $invoice->delivery_status == 'ongoing' ? 'selected' : null }}>
                                Ongoing</option>
                            <option value="on_delivery"
                                {{ $invoice->delivery_status == 'on_delivery' ? 'selected' : null }}>On Delivery</option>
                            <option value="complete" {{ $invoice->delivery_status == 'complete' ? 'selected' : null }}>
                                Complete</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Change Delivery Status</button>
                </form>
            </div>
        </div>
    </div>

@endsection
