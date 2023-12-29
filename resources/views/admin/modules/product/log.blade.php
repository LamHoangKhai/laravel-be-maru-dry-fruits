@extends('admin.master')
@push('js')
    <script src="{{  secure_asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{  secure_asset('administrator/js/log-import-export/main-log.js') }}" type="module"></script>
@endpush



@section('content')
    <input type="hidden" id="product_id" value="{{ $id }}">
    <input type="hidden" id="url" data-url="{{ route('admin.product.warehouse.getLog') }}">
    <input type="hidden" id="url-edit-import" data-url="{{ route('admin.product.warehouse.editImport', 'id') }}">

    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Products / Log
                </h4>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0 text-center"> {{ $product->name }}</h2>
                </div>
                <div class="card-body">
                    <h5><strong>Total Quantity</strong>: {{ $product->store_quantity + $product->stock_quantity }}kg</h5>
                    <h5><strong>Input Price</strong>: ${{ $inputPrice }}</h5>
                </div>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100 h-px-40 ">
                        <div class="input-group w-25" style="margin:0 0 0 16px">
                            <span class="input-group-text" h-px-40>Search</span>
                            <input type="text" class="form-control" id="search" placeholder="Enter shipment" />
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Input Price</th>
                                    <th>Shipment</th>
                                    <th>Type</th>
                                    <th>Expiration Date</th>
                                    <th>Transaction Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                <tr>
                                    <!-- render form administrator/js/log-import-export/main-log.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Quantity</th>
                                    <th>Input Price</th>
                                    <th>Shipment</th>
                                    <th>Type</th>
                                    <th>Expiration Date</th>
                                    <th>Transaction Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="pagination d-flex justify-content-between align-content-center">
                    <span class="card-header align-self-lg-center totalData"></span>

                    <div id="pagination" class="text-center card-header"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- /.card -->
@endsection
