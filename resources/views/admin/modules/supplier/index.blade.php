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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Other /</span>
                  Supplier
                </h4>

            </div>

            <div class="card">
                <div class="card-header">
                    <div class="nav-item d-flex justify-content-end w-100">

                        <a type="button" class="btn btn-primary" href="{{ route('admin.supplier.create') }}">
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
                                @if (!count($suppliers))
                                    <tr>
                                        <td valign="top" colspan="7" class="text-center">No matching records found</td>
                                    </tr>
                                @endif

                                @foreach ($suppliers as $supplier)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $supplier->name }}</td>
                                        <td>{{ $supplier->email }}</td>
                                        <td>{{ $supplier->address }}</td>
                                        <td>{{ $supplier->phone }}</td>
                                        <td class="g-2">


                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    <a href="{{ route('admin.supplier.edit', ['id' => $supplier->id]) }}"
                                                        class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="text-danger delete dropdown-item"
                                                        href="{{ route('admin.supplier.destroy', ['id' => $supplier->id]) }}"
                                                        id="delete"><i class="bx bx-trash me-1"></i>
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
