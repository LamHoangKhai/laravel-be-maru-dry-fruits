@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Other /</span>
                  Supplier /Edit
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.supplier.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter Name"
                                name="name" value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">* {{ $errors->get('name')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" class="form-control" placeholder="Enter email"
                                name="email" value="{{ old('email') }}" />
                            @if ($errors->has('email'))
                                <span class="text-danger">* {{ $errors->get('email')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" class="form-control" placeholder="Enter address"
                                name="address" value="{{ old('address') }}" />
                            @if ($errors->has('address'))
                                <span class="text-danger">* {{ $errors->get('address')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" class="form-control" placeholder="Enter phone"
                                name="phone" value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">* {{ $errors->get('phone')[0] }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px">Create</button>
                            <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
