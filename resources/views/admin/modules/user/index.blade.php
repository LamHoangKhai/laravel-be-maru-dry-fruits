@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/js/user/main.js') }}" type="module"></script>
@endpush

@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.user.getUsers') }}">
    <input type="hidden" id="url-edit" data-url="{{ route('admin.user.edit', 'id') }}">
    <input type="hidden" id="url-destroy" data-url="{{ route('admin.user.destroy', 'id') }}">


    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    User
                </h4>

            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between ">
                    <div class="d-flex align-content-center  justify-content-between  w-9">
                        <span class="align-self-lg-center">Show <select name="entries" id="showEntries">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="75">75</option>
                                <option value="100">100</option>
                            </select>entries </span>
                    </div>

                    <div class="nav-item d-flex justify-content-end w-75">
                        <div class="input-group w-25" style="margin:0 12px ">
                            <span class="input-group-text" h-px-40>Search</span>
                            <input type="text" class="form-control" id="search"
                                placeholder="Enter name or email,phone..." />
                        </div>



                        <a type="button" class="btn btn-primary" href="{{ route('admin.user.create') }}">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add User
                        </a>

                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Level</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">


                                <tr>
                                    <!-- render form administrator/js/user/main.js -->
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Level</th>
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
