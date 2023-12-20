@extends('admin.master')
@push('js')
    <script src="{{ asset('administrator/plugins/simple-bootstrap-paginator-master/simple-bootstrap-paginator.js') }}">
    </script>
    <script src="{{ asset('administrator/js/history-order/main.js') }}" type="module"></script>
@endpush
@section('content')
    <input type="hidden" id="url" data-url="{{ route('admin.order.getHistoryOrder') }}">
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Products / Log
                </h4>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100 h-px-40">
                        <div class="input-group w-px-200">
                            <label class="input-group-text" for="inputGroupSelect01">Status</label>
                            <select id="select" class="form-select ">
                                <option value="0" selected>All</option>
                                <option value="4">Complete</option>
                                <option value="5">Cancel</option>
                            </select>
                        </div>

                        <div class="input-group w-25" style="margin:0 12px ">
                            <span class="input-group-text" h-px-40>Search</span>
                            <input type="text" class="form-control" placeholder="Enter order No. , phone , email "
                                id="search">
                        </div>


                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>

                                    <th>Order #</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Status</th>
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
                                    <th>Order #</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
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
