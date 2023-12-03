@if ($errors->any())
    @push('handlejs')
        <script>
            $("#showModal").trigger("click");
        </script>
    @endpush
@endif

<div class="modal fade " id="addUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.user.store') }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" id="full_name" class="form-control" placeholder="Enter Name"
                                name="full_name" value="{{ old('full_name') }}" />
                            @if ($errors->has('full_name'))
                                <span class="text-danger">* {{ $errors->get('full_name')[0] }}</span>
                            @endif
                        </div>

                        <div class="col mb-2">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" class="form-control" placeholder="Enter phone"
                                name="phone" value="{{ old('phone') }}" />
                            @if ($errors->has('phone'))
                                <span class="text-danger">* {{ $errors->get('phone')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" class="form-control" placeholder="xxxx@xxx.xx"
                                name="email" value="{{ old('email') }}" />
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
                                name="address" value="{{ old('address') }}" />
                            @if ($errors->has('address'))
                                <span class="text-danger">* {{ $errors->get('address')[0] }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="status" class="form-label ">Stataus</label>
                            <select id="status" class="form-select" name="status">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Show</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hidden</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="level" class="form-label">Level</label>
                            <select id="level" class="form-select" name="level">
                                <option value="1" {{ old('level') == 1 ? 'selected' : '' }}>Admin</option>
                                <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Member</option>
                                <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Member VIP</option>
                            </select>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>
