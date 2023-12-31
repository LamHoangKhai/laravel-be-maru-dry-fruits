@extends('admin.master')
@push('js')
    <script>
        $("#customFile1").change((e) => {
            displaySelectedImage(e, "selectedImage");
        });

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
    </script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Other /</span>
                    Banner & Slider / Create
                </h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.slider-banner.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" id="title" class="form-control" placeholder="Enter title"
                                name="title" value="{{ old('title') }}" />
                            @if ($errors->has('title'))
                                <span class="text-danger">* {{ $errors->get('title')[0] }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" rows="3" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">* {{ $errors->get('description')[0] }}</span>
                            @endif
                        </div>
                    </div>


                    <div class="row g-3">
                        <div class="col mb-2">
                            <label for="status" class="form-label ">Stataus</label>
                            <select id="status" class="form-select" name="status">
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Show</option>
                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Hidden</option>
                            </select>
                        </div>
                        <div class="col mb-2">
                            <label for="position" class="form-label">Position</label>
                            <select id="position" class="form-select" name="position">
                                <option value="1" {{ old('position') == 1 ? 'selected' : '' }}>Slider</option>
                                <option value="2" {{ old('position') == 2 ? 'selected' : '' }}>Normal bannner</option>
                                <option value="3" {{ old('position') == 3 ? 'selected' : '' }}>Parallax banner
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <label for="customFile1" class="form-label">Image</label>

                        <div class="mb-4 d-flex">
                            <img id="selectedImage" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                alt="example placeholder" style="width: 250px; height: 250px" />
                        </div>
                        <div class="d-flex">
                            <div class="btn btn-primary btn-rounded w-px-250">
                                <label class="form-label text-white m-1 " for="customFile1">Choose file</label>
                                <input type="file" class="form-control d-none " id="customFile1"
                                    onchange="displaySelectedImage(event, 'selectedImage')" name="image" />
                            </div>
                        </div>
                        @if ($errors->has('image'))
                            <span class="text-danger">* {{ $errors->get('image')[0] }}</span>
                        @endif
                    </div>


                    <div class="row ">
                        <div class="col d-flex  justify-content-end">
                            <button type="submit" class="btn btn-primary " style="margin-right: 4px">Create</button>
                            <a href="{{ route('admin.slider-banner.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>

                    </div>
                </form>

            </div>

        </div>


    </div>
    <!-- /.card -->
@endsection
