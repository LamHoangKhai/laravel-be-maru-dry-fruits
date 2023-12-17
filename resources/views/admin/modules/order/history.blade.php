@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/js/log-import-export/main.js') }}" type="module"></script>
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
                    <div class="nav-item d-flex justify-content-end w-100 ">
                        <select id="select" class="form-select w-px-150">
                            <option value="1" selected>Import</option>
                            <option value="2">Export</option>
                        </select>
                        <input type="text" class="form-control  w-25" style="margin:0 0 0 16px" id="search"
                            placeholder="Enter shipment" />
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th class="max-110" id="quantity"></th>
                                    <th class="max-110">Current Quantity</th>
                                    <th>Shipment</th>
                                    <th>Type</th>
                                    <th class="max-110">Expiration Date</th>
                                    <th class="max-110">Transaction Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                <tr>
                                    <!-- render form administrator/js/log-import-export/main.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th class="max-110">Current Quantity</th>
                                    <th>Shipment</th>
                                    <th>Type</th>
                                    <th class="max-110">Expiration Date</th>
                                    <th class="max-110">Transaction Date</th>
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
