@extends('admin.master')
@php
    $orderSubtotal = 0;
    foreach ($orderItems as $item) {
        $orderSubtotal += $item['subtotal'];
    }
    $total = $orderSubtotal - $orderSubtotal * ($discount / 100);
@endphp

@push('handlejs')
    <script>
        $(document).ready(() => {
            $("#btn").click(function() {
                let divToPrint = $("#DivIdToPrint").html();
                let newWin = window.open("", "Print-Window");
                newWin.document.open();
                newWin.document.write(
                    '<html><body onload="window.print()">' +
                    divToPrint +
                    "</body></html>"
                );
                newWin.document.close();
                setTimeout(function() {
                    newWin.close();
                }, 10);
            });
        })
    </script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Order / Checking Order
                </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.order.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div id='DivIdToPrint'>
                        <!-- start invoice print -->
                        <style type="text/css">
                            body {
                                font-size: 16px;
                                line-height: 24px;
                                font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
                                color: #555;
                            }

                            .table_border tr td {
                                border: 1px solid #555 !important;
                            }

                            .itemrows td,
                            .heading td,
                            .padding td {
                                padding: 8px;
                            }

                            .total td {
                                padding: 4px;
                            }
                        </style>
                        <table cellpadding="0" cellspacing="0">
                            <table style="border:0;width:100%;">
                                <tr>
                                    <td colspan="4" align="center">
                                        <h3>Dummy Invoice</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b>Maru Dry Fruits</b></td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">35/6 Đường D5, Phường 25, Bình Thạnh, Thành phố Hồ Chí
                                        Minh
                                        72308</td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b>Contact:</b> 001800 1779</td>
                                </tr>
                                <tr class="padding">
                                    <td><b>Date:</b> {{ date('Y-m-d h:i:s') }} </td>
                                </tr>
                                <tr class="padding">
                                    <td><b>Note:</b> {{ $note }} </td>
                                </tr>

                                <tr class="heading" style="background:#eee;border-bottom:1px solid #ddd;font-weight:bold;">
                                    <td>
                                        Item
                                    </td>
                                    <td>
                                        Price
                                    </td>
                                    <td>
                                        Quantity
                                    </td>
                                    <td>
                                        Subtotal
                                    </td>
                                </tr>
                                @foreach ($orderItems as $item)
                                    @php $formatMass = $item['weight'] >= 1000 ? number_format($item['weight'] / 1000, 1, ',', '') . 'kg' : $item['weight'] . 'gram'; @endphp
                                    <tr class="itemrows" style="border-bottom:1px solid #d9dee3;">
                                        <td>{{ $item['name'] . ' ' . '(' . $formatMass . ')' }}</td>
                                        <td>${{ $item['price'] }}/100gram</td>

                                        <td>{{ $item['quantity'] }}</td>
                                        <td>${{ $item['subtotal'] }}</td>
                                    </tr>
                                @endforeach

                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Subtotal&nbsp;:&nbsp;${{ $orderSubtotal }}</b>

                                    </td>
                                </tr>
                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Discount&nbsp;:&nbsp;{{ $discount }}%</b>
                                    </td>
                                </tr>
                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Total&nbsp;:&nbsp;${{ $total }}</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">Thank You ! Visit Again</td>
                                </tr>
                            </table>
                        </table>
                        <!-- end invoice print -->
                    </div>


                    <div class="row ">
                        <input type="hidden" name="note" value="{{ $note }}">
                        @foreach ($orderItems as $item)
                            <input type="hidden" name="product[]" value="{{ $item['product'] }}">
                            <input type="hidden" name="subtotal[]" value="{{ $item['subtotal'] }}">
                            <input type="hidden" name="weight[]" value="{{ $item['weight'] }}">
                            <input type="hidden" name="quantity[]" value="{{ $item['quantity'] }}">
                        @endforeach

                        <input type="hidden" name="subtotalOrder" value="{{ $orderSubtotal }}">
                        <input type="hidden" name="discount" value="{{ $discount }}">
                        <input type="hidden" name="total" value="{{ $total }}">
                    </div>

                    <div class="row ">
                        <div class="d-flex bd-highlight mb-3">
                            <div class="me-auto p-2 bd-highlight">
                                <button type='button' id='btn' value='Print' class="bnt">
                                    <i class='bx bx-printer'></i>&nbsp;
                                    Print</button>
                            </div>
                            <div class="p-2 bd-highlight"> <button type="submit" class="btn btn-primary "
                                    style="margin:0 4px" id="submit">Create</button></div>
                            <div class="p-2 bd-highlight"> <a href="{{ route('admin.order.create') }}"
                                    class="btn btn-secondary">Cancel</a></div>
                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>
    <!-- /.card -->

    {{-- print invoice --}}
@endsection
