@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/js/product/main.js') }}" type="module"></script>
@endpush

@push('handlejs')
@endpush



@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.product.getProducts') }}">
    <input type="hidden" id="url-edit" data-url="{{ route('admin.product.edit', 'id') }}">
    <input type="hidden" id="url-destroy" data-url="{{ route('admin.product.destroy', 'id') }}">
    <input type="hidden" id="url-check" data-url="{{ route('admin.product.checkQuantity') }}">

    <input type="hidden" id="url-import" data-url="{{ route('admin.product.warehouse.createImport', 'id') }}">
    <input type="hidden" id="url-export" data-url="{{ route('admin.product.warehouse.createExport', 'id') }}">
    <input type="hidden" id="url-log" data-url="{{ route('admin.product.warehouse.log', 'id') }}">

    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Products
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100 h-px-40">
                        <div class="input-group w-25" style="margin:0 12px ">
                            <span class="input-group-text" h-px-40>Search</span>
                            <input type="text" class="form-control  w-25" id="search"
                                placeholder="Enter product name" />
                        </div>

                        <a type="button" class="btn btn-primary" href="{{ route('admin.product.create') }}">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add Product
                        </a>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th class="max-110">Stock Quantity</th>
                                    <th class="max-110">Store Quantity</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                <tr>
                                    <!-- render form administrator/js/prodcut/main.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th class="max-110">Stock Quantity</th>
                                    <th class="max-110">Store Quantity</th>
                                    <th>Status</th>
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
