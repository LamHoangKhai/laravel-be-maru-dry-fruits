@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
@endpush

@push('handlejs')
    <script src="{{ asset('administrator/js/user/main.js') }}" type="module"></script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('administrator/css/dropdown-menu-filter.css') }}">
@endpush

@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.user.getUsers') }}">
    <input type="hidden" id="url-edit" data-url="{{ route('admin.user.edit', 'id') }}">
    <input type="hidden" id="url-destroy" data-url="{{ route('admin.user.destroy', 'id') }}">


    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    User
                </h4>

            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between  ">
                    <div class="d-flex align-content-center  justify-content-between  w-9">
                        <span class="align-self-lg-center">Show <select name="entries" id="showEntries">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>entries </span>


                    </div>

                    <div class="nav-item d-flex justify-content-end w-75">

                        <button class="btn btn-secondary dropdown dropdown-toggle" data-toggle="dropdown">
                            Filter
                        </button>

                        <ul class="dropdown-menu columns-2">
                            <div class="row">

                                <div class="col-sm-6">
                                    <ul class="multi-column-dropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" style="font-weight: 700">
                                                Level
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="Checkme1" />
                                                    <label class="form-check-label" for="Checkme1">Check me</label>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-sm-6">
                                    <ul class="multi-column-dropdown">
                                        <li>
                                            <a class="dropdown-item" href="#" style="font-weight: 700">
                                                Level
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="Checkme1" />
                                                    <label class="form-check-label" for="Checkme1">Check me</label>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>


                        </ul>

                        <input type="text" class="form-control  w-25" style="margin:0 12px " id="search"
                            placeholder="Enter name or email,phone..." />
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser"
                            id="showModal">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add User
                        </button>

                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Total Purchase</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                <tr>
                                    <!-- render form administrator/js/user.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Id</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Level</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Total Purchase</th>
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
            @include('admin.modules.user.modals.add-new')


        </div>
        <!-- /.card -->
    @endsection
