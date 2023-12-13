@extends('admin.master')
@push('css')
    <style>
        .pagi-right nav {
            display: flex;
            justify-content: end;
        }
    </style>
@endpush

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
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="">Dashboard</a> /</span>
                    Categories
                </h4>

            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <div class="">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategory"
                            id="showModal">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add Category
                        </button>

                    </div>

                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">

                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @php
                                                if ($category->parent_id != 0) {
                                                    $parent_category = DB::table('categories')
                                                        ->select('name')
                                                        ->where('id', $category->parent_id)
                                                        ->get();
                                                    echo $parent_category[0]->name;
                                                }
                                            @endphp
                                        </td>

                                        <td>
                                            <span
                                                class="badge rounded-pill bg-{{ $category->status == 1 ? 'info' : 'dark' }}">
                                                {{ $category->status == 1 ? 'Show' : 'Hidden' }}</span>
                                        </td>
                                        <td>{{ date_format($category->created_at, 'Y/m/d H:i:s') }}</td>
                                        <td>{{ date_format($category->updated_at, 'Y/m/d H:i:s') }}</td>
                                        <td class="g-2">
                                            <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}">Edit</a>
                                            <a style="margin-right:-8px;margin-left:8px;" class="text-danger"
                                                href="{{ route('admin.category.destroy', ['id' => $category->id]) }}"
                                                id="delete" value="{{ $category->name }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Update At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <div class="card mt-4  pagi-right"> {{ $categories->links() }} </div>

                </div>

            </div>
            @include('admin.modules.category.modals.add-new')


        </div>
    </div>

    <!-- /.card -->
@endsection
