@extends('admin.master')

@push('js')
    <script src="{{ asset('administrator/js/print-invoice.js') }}"></script>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
{{$order}}
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage /</span>
                    Order / Invoice
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
                                    <td><b>Date:</b> </td>
                                </tr>
                                <tr class="padding">
                                    <td><b>Note:</b> </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center"><b>Invoice</b></td>
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

                                {{-- @foreach ($orderItems as $item)
                                    @php
                                        $formatMass = $item['weight'] >= 1000 ? number_format($item['weight'] / 1000, 1, ',', '') . 'kg' : $item['weight'] . 'gram';
                                    @endphp
                                    <tr class="itemrows" style="border-bottom:1px solid #d9dee3;">
                                        <td>{{ $item['name'] . ' ' . '(' . $formatMass . ')' }}</td>
                                        <td>${{ $item['price'] }}/100gram</td>

                                        <td>{{ $item['quantity'] }}</td>
                                        <td>${{ $item['subtotal'] }}</td>
                                    </tr>
                                @endforeach --}}

                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Subtotal&nbsp;:&nbsp;$</b>

                                    </td>
                                </tr>
                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Subtotal&nbsp;:&nbsp;%</b>
                                    </td>
                                </tr>
                                <tr class="total" stlye="margin-top:12px">
                                    <td align="right" colspan="3">
                                        <b>Total&nbsp;:&nbsp;$</b>
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
                        <div class="d-flex bd-highlight mb-3">
                            <div class="me-auto p-2 bd-highlight">
                                <button type='button' id='btn' value='Print' class="bnt">
                                    <i class='bx bx-printer'></i>&nbsp;
                                    Print</button>
                            </div>
                        </div>

                    </div>


            </div>

        </div>

    </div>
    <!-- /.card -->

    {{-- print invoice --}}
@endsection
