@extends('admin.master')



@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Banner & Slider
                </h4>

            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="">
                        <a type="button" href="{{ route('admin.slider-banner.create') }}" class="btn btn-primary text-while">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add Banner & Slider
                        </a>
                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered table-image">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Posistion</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                @if (!count($sliderBanner))
                                    <tr>
                                        <td valign="top" colspan="7" class="text-center">No matching records found</td>
                                    </tr>
                                @endif
                                @foreach ($sliderBanner as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td style="max-width: 250px;" class="text-wrap">{{ $item->description }}</td>
                                        <td>
                                            <img src="{{ $item->image ? $item->image : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScUUvHFXQ7e3dk1lqNvcXML2fFwC9X9X_lVA&usqp=CAU' }}"
                                                class="img" alt="Sheep" width="100" height="75">
                                        </td>
                                        <td>
                                            @php
                                                if ($item->position == 1) {
                                                    echo 'Slider';
                                                }
                                                if ($item->position == 2) {
                                                    echo 'Normal banner';
                                                }
                                                if ($item->position == 3) {
                                                    echo 'Parallax banner';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill bg-{{ $item->status == 1 ? 'info' : 'dark' }}">
                                                {{ $item->status == 1 ? 'Show' : 'Hidden' }}</span>
                                        </td>
                                        <td>{{ date('Y/m/d H:i:s', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('Y/m/d H:i:s', strtotime($item->updated_at)) }}</td>

                                        <td class="g-2">
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    <a href="{{ route('admin.slider-banner.edit', ['id' => $item->id]) }}"
                                                        class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="text-danger delete dropdown-item"
                                                        href="{{ route('admin.slider-banner.destroy', ['id' => $item->id]) }}"
                                                        value="{{ $item->id }}"><i class="bx bx-trash me-1"></i>
                                                        Delete</a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Posistion</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card mt-4  pagi-right"> {{ $sliderBanner->links() }} </div>

                </div>

            </div>



        </div>
    </div>

    <!-- /.card -->
@endsection
