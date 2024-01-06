@extends('admin.master')


@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home /</span>
                    DashBoard
                </h4>

            </div>

            <div class="card px-4 ">
                <div class="row d-flex justify-content-evenly">

                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('admin.order.index') }}">
                            <div class="card bg-info  mb-3">
                                <div class="card-body text-center ">
                                    <h2 class="card-title text-white">Order Pending</h2>
                                    <h1 class="card-text text-white">{{ $newOrder }}</h1>
                                </div>
                            </div>
                        </a>

                    </div>
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ route('admin.feedback.index') }}">
                            <div class="card bg-secondary  mb-3">
                                <div class="card-body text-center ">
                                    <h2 class="card-title text-white">New Feedback</h2>
                                    <h1 class="card-text text-white">{{ $newFeedback }}</h1>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <!-- /.card -->
@endsection
