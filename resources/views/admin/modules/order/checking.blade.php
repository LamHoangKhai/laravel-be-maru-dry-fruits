@extends('admin.master')
@php
    $subtotal = 0;
    foreach ($orderItems as $item) {
        $subtotal += $item['subtotal'];
    }
    $total = $subtotal - $subtotal * ($discount / 100);
@endphp


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Order / Checking Order
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.order.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="invoice p-3 mb-3">
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    Provisional invoice
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <b>Note:</b> {{ $note }}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- Table row -->
                        <div class="row mb-2">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Weight</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItems as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>${{ $item['price'] }}/100gram</td>
                                                <td>
                                                    {{ $item['weight'] >= 1000 ? number_format($item['weight'] / 1000, 1, ',', '') . 'kg' : $item['weight'] . 'gram' }}
                                                </td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>${{ $item['subtotal'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-6">
                                <h5 class="mb-1"><strong>Amount</strong></h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%;border-bottom-width: 0">Subtotal:</th>
                                                <td style="border-bottom-width: 0">${{ $subtotal }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width:50%;border-bottom-width: 0">Discount:</th>
                                                <td style="border-bottom-width: 0">{{ $discount }}%</td>
                                            </tr>
                                            <tr>
                                                <th style="width:50%;border-bottom-width: 0">Total:</th>
                                                <td style="border-bottom-width: 0">${{ $total }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- this row will not appear when printing -->

                    </div>


                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <input type="hidden" name="note" value="{{ $note }}">


                            @foreach ($orderItems as $item)
                                <input type="hidden" name="product[]" value="{{ $item['product'] }}">
                                <input type="hidden" name="price[]" value="{{ $item['price'] }}">
                                <input type="hidden" name="weight[]" value="{{ $item['weight'] }}">
                                <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                            @endforeach

                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                            <input type="hidden" name="discount" value="{{ $discount }}">
                            <input type="hidden" name="total" value="{{ $total }}">

                            <button type="submit" class="btn btn-primary " style="margin-right: 4px"
                                id="submit">Create</button>
                            <a href="{{ route('admin.order.create') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
