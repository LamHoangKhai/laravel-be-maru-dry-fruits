@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Product / Detail
                </h4>

            </div>
            <div class="card-body">
                <div class="col-md">
                    <div class="card mb-3">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img class="card-img card-img-left" src="{{ $product->image }}" alt="Card image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h3 class="card-title">{{ $product->name }}</h3>
                                    <h5 class="card-text">Category : {{ $product->category->name }}</h5>
                                    <h5 class="card-text">Price : ${{ $product->price }}</h5>
                                    <h5 class="card-text">Input Price :
                                        ${{ DB::table('warehouse')->where('product_id', $product->id)->max('input_price') }}
                                    </h5>
                                    <h5 class="card-text">Total Quantity :
                                        {{ $product->store_quantity + $product->stock_quantity }}kg</h5>
                                    <h5 class="card-text">Expiration Date :
                                        {{ $exparationDate ? $exparationDate->expiration_date : '' }}</h5>
                                    <h5 class="card-text">Description : <br>{!! $product->description !!}
                                    </h5>
                                    <h5 class="card-text">Nutrition Detail : <br>{!! $product->nutrition_detail !!}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
