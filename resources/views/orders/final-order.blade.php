@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('fail'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('fail')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (!empty($message))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {!!$message!!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="info">
            <p>رقم الطلب: {{$final_order[0]->order_number}}</p>
            <p>اسم العامل: {{$final_order[0]->user->name}}</p>
            <p>التاريخ: {{date('d-m-Y -- h:i A', strtotime($final_order[0]->updated_at))}}</p>
        </div>
        <p>اسم العميل: {{$final_order[0]->customer->name}}</p>
        <div class="table-responsive-sm ">
            <table id="dataTable" class="table table-bordered">
                <thead>
                <tr>
                    <th class="hide-print">رقم الباركود</th>
                    <th>اسم المنتج</th>
                    <th>سعر الواحدة</th>
                    <th>الكمية</th>
                    <th>السعر الكلي</th>
                    <th class="hide-print">ارجاع منتج</th>
                </tr>
                </thead>
                <tbody> {{--@php($sum = 0)--}}
                @foreach ($final_order as $item)
                    <tr>
                        <td class="hide-print">{{$item->product->barcode}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        {{--@php($sum += $item->product->price_of_sell*$item->quantity)--}}
                        <td class="cost">{{$item->price*$item->quantity}}</td>
                        <td class="hide-print">
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#remove_product"
                                    onclick="remove_product({{$item->product->id}},{{$item->id}},{{$item->order_number}} ,{{$item->quantity}},{{$item->price}})">
                                ارجاع منتج <i class="fa fa-repeat"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"><b>المجموع</b></td>
                    <td colspan="1" style="border-right: 0;" class="hide-print"></td>
                    <td class="final-sum" colspan="2"><b>{{$item->sum}}</b></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <center>
            <button type="button" class="btn btn-success" id="print">طباعة <i class="fa fa-print"></i></button>
            <br><br>
            <a href="{{url()->previous()}}" class="btn btn-danger">رجوع</a>
        </center>
    </div>

    {{--Modal--}}
    <div class="modal fade" id="remove_product" tabindex="-1" aria-labelledby="remove_productLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remove_productLabel">الكمية المراد ارجاعها</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show ajax-error-hide"
                         style="display: none; width: 100%;" role="alert">
                        <span class="ajax-error"></span>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                    </div>
                    <form method="post" action="{{route('return.product')}}">
                        @csrf

                        <input id="product_id" type="hidden" name="product_id">
                        <input id="order_id" type="hidden" name="order_id">
                        <input id="order_number" type="hidden" name="order_number">
                        <input id="order_quantity" type="hidden" name="order_quantity">
                        <input id="order_price" type="hidden" name="order_price">

                        <div class="form-group hide-quantity">
                            <label for="quantity_to_remove">الكمية</label>
                            <input id="quantity_to_remove" required value="0" type="number" step="0.1"
                                   class="form-control"
                                   placeholder="الكمية" name="quantity_to_remove">
                        </div>
                        @error('quantity_to_remove')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <br>
                        <center>
                            <button type="submit" class="btn btn-primary notallowed">حفظ التعديلات</button>
                        </center>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@endpush
@push('bottom-script')
    <script type="text/javascript" src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/jquery-easing/jquery.easing.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/jquery.dataTables.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datatables/datatables-demo.js')}}"></script>
    <script type="text/javascript">
        $('div.dataTables_length select').css('width', '100% !important');
        $(document).ready(function () {
            let o400 = new Option("option text", "99000000");
            $(o400).html("الكل");
            setTimeout(function () {
                $("select[name='dataTable_length']").append(o400);
            }, 100)
        });

        //print
        $('#print').click(function () {
            let divToPrint = $('.col-sm-12').eq(2)[0];
            let info = $('.info').html();

            let newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html dir="rtl"><body onload="window.print()"><style>.hide-print{display:none;} table{width: 100%;} table, th, td {border: 1px solid black;border-collapse: collapse; direction:rtl; text-align-last: center;}</style>' + info + '<br>' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        });
    </script>
    <script>
        function remove_product(product_id, order_id, order_number, order_quantity, order_price) {
            $('#product_id').val(product_id)
            $('#order_id').val(order_id)
            $('#order_number').val(order_number)
            $('#order_quantity').val(order_quantity)
            $('#order_price').val(order_price)
            // console.log("product id: "+product_id)
            // console.log("order id: "+order_id)
            // console.log("order quantity: "+order_quantity)
            // console.log("order price: "+order_price)
        }
    </script>
    <x-data-table-filter-component/>
@endpush
