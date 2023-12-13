@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('administrator/js/product/main.js') }}" type="module"></script>
    <script src="{{ asset('administrator/js/product/general.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
@endpush



@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/css/dropdown-menu-filter.css') }}">
    <style>
        .container {
            padding: 2rem 0rem;
        }

        h4 {
            margin: 2rem 0rem 1rem;
        }

        .table-image {

            td,
            th {
                vertical-align: middle;
            }
        }

        .image {
            max-width: 50px;
            max-height: 50px;
        }

        .max {
            max-width: 100px !important;
            white-space: pre-wrap !important;
        }
    </style>
@endpush

@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.product.getProducts') }}">
    <input type="hidden" id="url-edit" data-url="{{ route('admin.product.edit', 'id') }}">
    <input type="hidden" id="url-destroy" data-url="{{ route('admin.product.destroy', 'id') }}">
    <input type="hidden" id="urlPathUploads" data-url="{{ route('urlPathUploads') }}">


    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Products
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100">
                        <input type="text" class="form-control  w-25" style="margin:0 12px " id="search"
                            placeholder="Enter name" />
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct"
                            id="showModal">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add Product
                        </button>

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
                                    <th class="max">Stock Quantity</th>
                                    <th class="max">Store Quantity</th>
                                    <th>Status</th>
                                    <th >Created At</th>
                                    <th >Updated At</th>
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
                                    <th class="max">Stock Quantity</th>
                                    <th class="max">Store Quantity</th>
                                    <th>Status</th>
                                    <th >Created At</th>
                                    <th >Updated At</th>
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
            @include('admin.modules.product.modals.add-new')


        </div>
    </div>

    <!-- /.card -->
@endsection
