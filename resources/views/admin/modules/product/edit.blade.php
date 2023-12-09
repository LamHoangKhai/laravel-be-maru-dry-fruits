@extends('admin.master')
@push('handlejs')
    <script src="{{ asset('administrator/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        function displaySelectedImage(event, elementId) {
            const selectedImage = document.getElementById(elementId);
            const fileInput = event.target;

            if (fileInput.files && fileInput.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    selectedImage.src = e.target.result;
                };

                reader.readAsDataURL(fileInput.files[0]);
            }
        }

        $(document).ready(() => {
            $("#description").summernote();
            $("#nutrition_detail").summernote();

        })
    </script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    User / Edit
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-2">
                        <div class="col mb-2">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" class="form-control" placeholder="Enter Name"
                                name="name" value="{{ old('name', $data->name) }}" />
                            @if ($errors->has('name'))
                                <span class="text-danger">* {{ $errors->get('name')[0] }}</span>
                            @endif
                        </div>

                        <div class="col mb-2">
                            <label for="price" class="form-label">Price</label>
                            <input type="text" id="price" class="form-control" placeholder="Enter price/100gram"
                                name="price" value="{{ old('price', $data->price) }}" />
                            @if ($errors->has('price'))
                                <span class="text-danger">* {{ $errors->get('price')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description">{{ old('description', $data->description) }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">* {{ $errors->get('description')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="nutrition_detail" class="form-label">Nutrition</label>
                            <textarea class="form-control" id="nutrition_detail" rows="3" name="nutrition_detail">{{ old('nutrition_detail', $data->nutrition_detail) }}</textarea>
                            @if ($errors->has('nutrition_detail'))
                                <span class="text-danger">* {{ $errors->get('nutrition_detail')[0] }}</span>
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
                            <label for="category_id" class="form-label">Parent</label>
                            <select id="category_id" class="form-select" name="category_id">
                                @php
                                    RootCategory($categories, old('category_id', $data->category_id));
                                @endphp
                            </select>
                        </div>
                    </div>

                    <div class="row w-px-200 ">
                        <label for="" class="form-label">Current Image</label>
                        <div class="mb-4 d-flex justify-content-center">
                            <img src="{{ asset('uploads/' . $data->image) }}" alt=""
                                style="width: 150px; height: 150px" />
                        </div>
                    </div>

                    @if ($errors->has('image'))
                        <span class="text-danger">* {{ $errors->get('image')[0] }}</span>
                    @endif
                    <div class="row w-px-200 ">
                        <label for="customFile1" class="form-label">New Image</label>
                        <div class="mb-4 d-flex justify-content-center">
                            <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                alt="example placeholder" style="width: 150px; height: 150px" />
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-primary btn-rounded">
                                <label class="form-label text-white m-1" for="customFile1">Choose file</label>
                                <input type="file" class="form-control d-none" id="customFile1"
                                    onchange="displaySelectedImage(event, 'selectedImage')" name="image" />
                            </div>
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
    <!-- /.card -->
@endsection
