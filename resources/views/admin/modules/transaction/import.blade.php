@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/js/import/main.js') }}" type="module"></script>
@endpush


@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <input type="hidden" id="url" data-url="{{ route('admin.transaction.getImports') }}">
        <input type="hidden" id="url-edit" data-url="{{ route('admin.transaction.edit', 'id') }}">
        <input type="hidden" id="url-destroy" data-url="{{ route('admin.transaction.destroy', 'id') }}">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Transaction / Import
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100">
                        <input type="text" class="form-control  w-25" style="margin:0 12px " id="search"
                            placeholder="Enter name" />
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImport"
                            id="showModal">
                            <i class='bx bx-plus-circle'></i>&nbsp; Import
                        </button>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Current Quantity</th>
                                    <th>Shipment</th>
                                    <th>Transaction Date</th>
                                    <th>Expiration Date</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                <tr>
                                    <!-- render form administrator/js/transaction/main.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Supplier</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Current Quantity</th>
                                    <th>Shipment</th>
                                    <th>Transaction Date</th>
                                    <th>Expiration Date</th>
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
            @include('admin.modules.transaction.modals.create-import')


        </div>
    </div>

    <!-- /.card -->
@endsection
