@extends('layouts.app')

@section('content')
    <div class="container">
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
                    <th class="hide">رقم الباركود</th>
                    <th>اسم المنتج</th>
                    <th>سعر الواحدة</th>
                    <th>الكمية</th>
                    <th>السعر الكلي</th>
                </tr>
                </thead>
                <tbody> {{--@php($sum = 0)--}}
                @foreach ($final_order as $item)
                    <tr>
                        <td class="hide">{{$item->product->barcode}}</td>
                        <td>{{$item->product->name}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->quantity}}</td>
                        {{--@php($sum += $item->product->price_of_sell*$item->quantity)--}}
                        <td class="cost">{{$item->price*$item->quantity}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3"><b>المجموع</b></td>
                    <td class="final-sum" colspan="2"><b>{{$item->sum}}</b></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <center>
            <button type="button" class="btn btn-success" id="print">طباعة <i class="fa fa-print"></i></button>
        </center>
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
            let o400 = new Option("option text", "5000000");
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

            newWin.document.write('<html dir="rtl"><body onload="window.print()"><style>.hide{display:none;} table{width: 100%;} table, th, td {border: 1px solid black;border-collapse: collapse; direction:rtl; text-align-last: center;}</style>' + info + '<br>' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        });
    </script>
    <x-data-table-filter-component/>
@endpush
