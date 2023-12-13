@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    User / Edit
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.warehouse.update', ['id' => $id]) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col mb-2">
                            <label for="product_id" class="form-label ">Product</label>
                            <select id="product_id" class="form-select" name="product_id">
                                <option value="">Choose Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id', $data->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))
                                <span class="text-danger">* {{ $errors->get('product_id')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="supplier_id" class="form-label">Supplier</label>
                            <select id="supplier_id" class="form-select" name="supplier_id">
                                <option value="">Choose Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', $data->supplier_id) == $supplier->id ? 'selected' : '' }}>
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
                                placeholder="Enter quantity (kilogram)" name="quantity"
                                value="{{ old('quantity', $data->quantity) }}" />
                            @if ($errors->has('quantity'))
                                <span class="text-danger">* {{ $errors->get('quantity')[0] }}</span>
                            @endif
                        </div>

                        <div class="col mb-2">
                            <label for="expiration_date" class="form-label">Expiration date</label>
                            <input class="form-control" type="date" id="expiration_date" name="expiration_date"
                                value="{{ old('expiration_date', $data->expiration_date) }}">
                            @if ($errors->has('expiration_date'))
                                <span class="text-danger">* {{ $errors->get('expiration_date')[0] }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" id="note" class="form-control" placeholder="Enter note"
                                name="note" value="{{ old('note', $data->note) }}" />
                        </div>
                    </div>



                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px">Update</button>
                            <a href="{{ route('admin.warehouse.import') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
