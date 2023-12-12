@if ($errors->any())
    @push('handlejs')
        <script>
            $("#showModal").trigger("click");
        </script>
    @endpush
@endif

<div class="modal fade " id="addSupplier" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Add New Supllier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.other.supplier.store') }}" enctype="multipart/form-data">
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


                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
