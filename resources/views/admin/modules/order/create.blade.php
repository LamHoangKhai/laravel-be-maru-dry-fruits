@extends('admin.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/plugins/select2/css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('administrator/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('js')
    <script src="{{ asset('administrator/js/order/create.js') }}"></script>
    <script src="{{ asset('administrator/plugins/select2/js/select2.min.js') }}"></script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <input type="hidden" id="url" data-url="{{ route('admin.order.getProduct') }}">
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
                            <button type="button" class="btn btn-sm btn-info" id="add-item"><i
                                    class="bx bx-plus-circle"></i>&nbsp;
                                Add item</button>
                        </div>
                    </div>

                    {{--                  
                    <select class="js-example-basic-single" name="state[]">
                        <option value="AL">Alabama</option>

                        <option value="WY">Wyoming</option>
                    </select>
                    <select class="js-example-basic-single" name="state[]">
                        <option value="AL">Alabama</option>

                        <option value="WY">Wyoming</option>
                    </select> --}}

                    <div class="row">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="" class="form-label">Product</label>
                            </div>
                            <div class="col mb-2">
                                <label for="" class="form-label">Weight</label>
                            </div>
                            <div class="col mb-2">
                                <label for="" class="form-label">Quantity</label>
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


                    <div class="row g-2">
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
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px"
                                id="submit">Checking</button>
                            <a href="{{ route('admin.order.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
    <!-- /.card -->
@endsection
