@extends('admin.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    User / Edit
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.user.update', ['id' => $id]) }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" id="full_name" class="form-control" placeholder="Enter Name"
                                name="full_name" value="{{ old('full_name', $data->full_name) }}" />
                            @if ($errors->has('full_name'))
                                <span class="text-danger">* {{ $errors->get('full_name')[0] }}</span>
                            @endif
                        </div>

                        <div class="col mb-2">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" class="form-control" placeholder="Enter phone"
                                name="phone" value="{{ old('phone', $data->phone) }}" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">* {{ $errors->get('phone')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="email" class="form-label">Email</label>
                            <span class="form-control text-danger"
                                style="cursor:no-drop; background: rgba(0, 0, 0, 0.253);font-weight: 700;">{{ old('email', $data->email) }}</span>
                            @if ($errors->has('email'))
                                <span class="text-danger">* {{ $errors->get('email')[0] }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input class="form-control" type="password" id="password" placeholder="Enter password"
                                name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">* {{ $errors->get('password')[0] }}</span>
                            @endif
                        </div>
                        <div class="col mb-2">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input class="form-control" type="password" id="confirm_password"
                                placeholder="Enter confirm password" name="confirm_password">
                            @if ($errors->has('confirm_password'))
                                <span class="text-danger">* {{ $errors->get('confirm_password')[0] }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" id="address" class="form-control" placeholder="Enter address"
                                name="address" value="{{ old('address', $data->address) }}" />
                            @if ($errors->has('address'))
                                <span class="text-danger">* {{ $errors->get('address')[0] }}</span>
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
                            <label for="level" class="form-label">Level</label>
                            <select id="level" class="form-select" name="level" >
                                {{-- note allow admin change level --}}
                                {{-- @if ($mySelf)
                                    <option>Not change!
                                    </option>
                                @else --}}
                                    <option value="1" {{ old('level', $data->level) == 1 ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="2" {{ old('level', $data->level) == 2 ? 'selected' : '' }}>Member
                                    </option>
                                    <option value="3" {{ old('level', $data->level) == 3 ? 'selected' : '' }}>Member
                                        VIP
                                    </option>
                                {{-- @endif --}}

                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Update</button>
                </form>
            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
