@if ($errors->any())
    @push('handlejs')
        <script>
            $("#showModal").trigger("click");
        </script>
    @endpush
@endif

<div class="modal fade " id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.category.store') }}">
                    @csrf
                    <div class="row ">
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter name category"
                                name="name" value="{{ old('name') }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">* {{ $errors->get('name')[0] }}</span>
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
                            <label for="parent_id" class="form-label">Parent</label>
                            <select id="parent_id" class="form-select" name="parent_id">
                                <option value="0">---Root---</option>
                                @php
                                    RootCategory($categories, old('parent_id', 0));
                                @endphp
                            </select>
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
