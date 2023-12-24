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
                <form method="POST" action="{{ route('admin.weight-tag.store') }}">
                    @csrf

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="mass" class="form-label">Mass</label>
                            <input type="text" id="mass" class="form-control" placeholder="Enter gram (1000 = 1kg)"
                                name="mass" value="{{ old('mass') }}" />
                            @if ($errors->has('mass'))
                                <span class="text-danger">* {{ $errors->get('mass')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px">Create</button>
                            <a href="{{ route('admin.weight-tag.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>
            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
