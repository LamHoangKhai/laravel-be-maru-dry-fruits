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

            // show modal
            await Swal.fire({
                title: "Are you sure?",
                html: `Do you want to delete it or not?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    if (result.isConfirmed) {
                        return (window.location.href = url);
                    }
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
                    Transaction / Supplier
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.other.supplier.create') }}">
                            <i class='bx bx-plus-circle'></i>&nbsp; Supplier
                        </a>

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table  table-bordered ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody class="table-border-bottom-0" id="renderData">
                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td class="g-2">
                                            <a
                                                href="{{ route('admin.other.supplier.edit', ['id' => $supplier->id]) }}">Edit</a>
                                            <a style="margin-right:-8px;margin-left:8px;"
                                                href="{{ route('admin.other.supplier.destroy', ['id' => $supplier->id]) }}"
                                                id="delete" value="{{ $supplier->name }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card mt-4  pagi-right"> {{ $suppliers->links() }} </div>
                </div>

            </div>



        </div>
    </div>

    <!-- /.card -->
@endsection
