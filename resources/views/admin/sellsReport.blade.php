@extends('layouts.admin')
@section('admin-content')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <div class="container">
            @if (!empty($message))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!!$message!!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <h3 class="text-center mb-2"><u>عمليات البيع</u></h3>
            <div class="table-responsive-sm ">
                <table id="dataTable" class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="cursor: pointer;">رقم العملية</th>
                        <th style="cursor: pointer;">اسم العامل</th>
                        <th style="cursor: pointer;">تاريخ العملية</th>
                        <th style="cursor: pointer;">التكلفة</th>
                    </tr>
                    </thead>
                    <tbody> @php($sum = 0)
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="{{route('order',$order->order_number)}}">
                                    ط {{$order->order_number}}</a></td>
                            <td>{{$order->user->name}}</td>
                            <td>{{date('Y-m-d -- h:i A', strtotime($order->updated_at))}}</td>
                            @php($sum += $order->sum)
                            <td class="cost">{{$order->sum}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"><b>المجموع</b></td>
                        <td class="final-sum" colspan="1"><b>{{$sum}}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <br>
            <center>
                <button type="button" class="btn btn-success" id="print">طباعة <i class="fa fa-print"></i></button>
            </center>
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
    <script type="text/javascript"
            src="{{asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
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

            let newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html dir="rtl"><body onload="window.print()"><style>.hide{display:none;} table{width: 100%;} table, th, td {border: 0px solid black;border-collapse: collapse; direction:rtl; text-align-last: center;}</style>' + '<br>' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        });
    </script>
    <x-data-table-filter-component/>
@endpush
