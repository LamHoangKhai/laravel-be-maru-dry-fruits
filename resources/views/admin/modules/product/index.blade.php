@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
@endpush

@push('handlejs')
    <script src="{{ asset('administrator/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('administrator/js/product/main.js') }}" type="module"></script>
    <script>
        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        $(document).ready(() => {
            $("#description").summernote();
            $("#nutrition_detail").summernote();

        })
    </script>
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
    </style>
@endpush

@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.product.getProducts') }}">
    <input type="hidden" id="url-edit" data-url="{{ route('admin.product.edit', 'id') }}">
    <input type="hidden" id="url-destroy" data-url="{{ route('admin.product.destroy', 'id') }}">


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
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock Quantity</th>
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
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Stock Quantity</th>
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
            @include('admin.modules.product.modals.add-new')


        </div>
    </div>

    <!-- /.card -->
@endsection
