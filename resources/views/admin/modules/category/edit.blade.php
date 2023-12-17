@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Category / Edit
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.category.update', ['id' => $id]) }}">
                    @csrf
                    <div class="row ">
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter name category"
                                name="name" value="{{ old('name', $data->name) }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">* {{ $errors->get('name')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="status" class="form-label ">Stataus</label>
                            <select id="status" class="form-select" name="status">
                                <option value="1" {{ old('status', $data->status) == 1 ? 'selected' : '' }}>Show
                                </option>
                                <option value="2" {{ old('status', $data->status) == 2 ? 'selected' : '' }}>Hidden
                                </option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="parent_id" class="form-label">Parent</label>
                            <select id="parent_id" class="form-select" name="parent_id">
                                <option value="0">---Root---</option>

                                <?php
                                RootCategory($categories, old('parent_id', $data->parent_id));
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px">Update</button>
                            <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>
            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
