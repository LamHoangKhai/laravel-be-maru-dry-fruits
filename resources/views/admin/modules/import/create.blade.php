@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Product / Import
                </h4>

            </div>
            <div class="card-body">

                <form method="POST" action="{{ route('admin.warehouse.importStore') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col mb-2">
                            <label for="product_id" class="form-label ">Product</label>
                            <span class="form-control" style="cursor:no-drop;">{{ $product->name }}</span>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select id="supplier_id" class="form-select" name="supplier_id">
                                <option value="">Choose Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', 0) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('supplier_id'))
                                <span class="text-danger">* {{ $errors->get('supplier_id')[0] }}</span>
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

                        <div class="col mb-2">
                            <label for="expiration_date" class="form-label">Expiration date</label>
                            <input class="form-control" type="date" id="expiration_date" name="expiration_date"
                                value="{{ old('expiration_date') }}">
                            @if ($errors->has('expiration_date'))
                                <span class="text-danger">* {{ $errors->get('expiration_date')[0] }}</span>
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
                            <button type="submit" class="btn btn-primary" style="margin-right: 4px">Import</button>
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
