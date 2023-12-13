@if ($errors->any())
    @push('handlejs')
        <script>
            $("#showModal").trigger("click");
        </script>
    @endpush
@endif

<div class="modal fade " id="addExport" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel3">Export</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.warehouse.exportStore') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col mb-2">
                            <label for="product_id" class="form-label ">Product</label>
                            <select id="product_id" class="form-select" name="product_id">
                                <option value="">Choose Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old('product_id', 0) === $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('product_id'))
                                <span class="text-danger">* {{ $errors->get('product_id')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="shipment" class="form-label">Shipment</label>
                            <select id="shipment" class="form-select" name="shipment">
                                <option value="">Choose Shipment</option>

                            </select>
                            @if ($errors->has('shipment'))
                                <span class="text-danger">* {{ $errors->get('shipment')[0] }}</span>
                            @endif
                        </div>
                    </div>



                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" id="quantity" class="form-control"
                                placeholder="Enter quantity (kilogram)" name="quantity" value="{{ old('quantity') }}" />
                            @if ($errors->has('quantity'))
                                <span class="text-danger">* {{ $errors->get('quantity')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="note" class="form-label">Note</label>
                            <input type="text" id="note" class="form-control" placeholder="Enter note"
                                name="note" value="{{ old('note') }}" />
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
