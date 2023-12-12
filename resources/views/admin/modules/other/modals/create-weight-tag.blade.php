@if ($errors->any())
    @push('handlejs')
        <script>
            $("#showModal").trigger("click");
        </script>
    @endpush
@endif

<div class="modal fade " id="addWeightTag" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Add New Weight Tag</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.other.weight-tag.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="mass" class="form-label">Mass</label>
                            <input type="text" id="mass" class="form-control"
                                placeholder="Enter gram (1000 = 1kg)" name="mass" value="{{ old('mass') }}" />
                            @if ($errors->has('mass'))
                                <span class="text-danger">* {{ $errors->get('mass')[0] }}</span>
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
