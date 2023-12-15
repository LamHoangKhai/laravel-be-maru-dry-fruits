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
        //check category has many product and has many product 
        $(".delete").click(async (e) => {
            e.preventDefault();
            const url = e.target.href;
            const urlCheck = $("#url-check").attr("data-url");
            const category_id = e.target.getAttribute("value");

            $.ajax({
                type: "POST",
                url: urlCheck,
                data: {
                    category_id
                },
                dataType: "json",
                success: (res) => {
                    Swal.fire({
                        title: "Are you sure?",
                        html: `This category has ${res.countProduct} products and ${res.countProductInStock} product is in stock`,
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
                },
                error: function(error) {
                    console.log(error.message);
                },
            });
        });
    </script>
@endpush

@section('content')
    <input type="hidden" id="url-check" data-url="{{ route('admin.category.checkRelatedCategory') }}">

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
                        <a type="button" href="{{ route('admin.category.create') }}" class="btn btn-primary text-while">
                            <i class='bx bx-plus-circle'></i>&nbsp; Add Category
                        </a>
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
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu" style="">
                                                    <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}"
                                                        class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                    <a class="text-danger delete dropdown-item"
                                                        href="{{ route('admin.category.destroy', ['id' => $category->id]) }}"
                                                        value="{{ $category->id }}"><i class="bx bx-trash me-1"></i>
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



        </div>
    </div>

    <!-- /.card -->
@endsection
