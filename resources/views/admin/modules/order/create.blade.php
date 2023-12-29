@extends('admin.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('administrator/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
    <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script src="{{ asset('administrator/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('administrator/js/order/create-order.js') }}" type="module"></script>
@endpush


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <input type="hidden" id="url-detail" data-url="{{ route('admin.product.detail') }}">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Order / Create
                </h4>

            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.order.checking') }}" enctype="multipart/form-data"
                    id="form">
                    @csrf

                    <div class="row">
                        <div class="col mb-2">
                            <select class="form-select js-example-basic-single" id="select" placeho>
                                <option value="" disabled selected>Please choose item</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <div class="row">
                        <div class="row">
                            <div class="col mb-2 text-center">
                                <label for="" class="form-label"><strong>Product</strong></label>
                            </div>
                            <div class="col mb-2  text-center">
                                <label for="" class="form-label"><strong>Price</strong></label>
                            </div>
                            <div class="col mb-2  text-center">
                                <label for="" class="form-label"><strong>Weight</strong></label>
                            </div>
                            <div class="col mb-2  text-center">
                                <label for="" class="form-label"><strong>Quantity</strong></label>
                            </div>
                        </div>
                        <div class="col mb-2">
                            <div class="row"id="list-item">

                            </div>

                            @if ($errors->has('product'))
                                <span class="text-danger">* {{ $errors->get('product')[0] }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row g-2 mt-4">
                        <div class="col mb-2 ">
                            <label for="discount" class="form-label">Discount</label>
                            <input type="number" id="discount" class="form-control w-px-200" name="discount"
                                min="0" value="0" />
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
                        <div class="col d-flex  justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px"
                                id="submit">Checking</button>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>




        <!-- The Modal -->
        <div class="modal fade" id="showScan">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <input type="hidden" class="close closeModal" data-dismiss="modal" aria-label="Close">

                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <video id="preview" style="width: 100%;height:auto"></video>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- /.card -->
@endsection
