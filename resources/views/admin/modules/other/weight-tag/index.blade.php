@extends('admin.master')

@push('handlejs')
    <script>
        $("#delete").click(async (e) => {
            e.preventDefault();
            const url = e.target.href;
            const name = e.target.getAttribute("value");
            // show modal
            await Swal.fire({
                title: "Are you sure?",
                html: `Bạn có muốn xóa <strong>${name}</strong> hay không`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    return (window.location.href = url);
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="container-xl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Other / Weight Tag
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWeightTag"
                            id="showModal">
                            <i class='bx bx-plus-circle'></i>&nbsp; Weight Tag
                        </button>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Mass</th>

                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                @foreach ($weights as $weight)
                                    <tr>
                                        <td style="width: 20px">{{ $loop->iteration }}</td>
                                        <td>{{ $weight->mass }}</td>
                                        <td style="width: 20px">
                                            <a style="margin-right:-8px;margin-left:8px;"
                                                href="{{ route('admin.other.weight-tag.destroy', ['id' => $weight->id]) }}"
                                                id="delete" value="{{ $weight->name }}" class="text-danger">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Mass</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
            @include('admin.modules.other.modals.create-weight-tag')


        </div>
    </div>

    <!-- /.card -->
@endsection
