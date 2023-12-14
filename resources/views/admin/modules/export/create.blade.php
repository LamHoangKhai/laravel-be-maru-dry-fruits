@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Product / Export
                </h4>

            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('admin.warehouse.exportStore') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col mb-2">
                            <label for="product_id" class="form-label ">Product</label>
                            <span class="form-control" style="cursor:no-drop;">{{ $product->name }}</span>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                        </div>
                    </div>

                    <div class="row ">
                        <div class="col mb-2">
                            <label for="shipment" class="form-label ">Shipment</label>
                            <select id="shipment" class="form-select " name="shipment">
                                <option value="">Choose Shipment</option>
                                @foreach ($imports as $import)
                                    <option class="d-flex justify-content-between " value="{{ $import->shipment }}"
                                        {{ old('shipment', 0) == $import->id ? 'selected' : '' }}>
                                        Supplier: {{ $import->supplier->name }} &nbsp;&nbsp;--&nbsp;&nbsp;
                                        Current Quantity : {{ $import->current_quantity }} &nbsp;&nbsp;--&nbsp;&nbsp;
                                        Expiration Date : {{ $import->expiration_date }} &nbsp;&nbsp;--&nbsp;&nbsp;
                                        Shipment : {{ $import->shipment }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('shipment'))
                                <span class="text-danger">* {{ $errors->get('shipment')[0] }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" id="quantity" class="form-control"
                                placeholder="Enter quantity (kilogram)" name="quantity" value="{{ old('quantity') }}" />
                            @if ($errors->has('quantity'))
                                <span class="text-danger">* {{ $errors->get('quantity')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" id="note" class="form-control" placeholder="Enter note"
                                name="note" value="{{ old('note') }}" />
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary" style="margin-right: 4px">Export</button>
                            <a type="button" class="btn btn-outline-secondary" href="{{ route('admin.product.index') }}">
                                Cancel
                            </a>
                        </div>

                    </div>


                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
