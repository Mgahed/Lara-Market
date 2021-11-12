@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{session('success')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('fail'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session('fail')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive-sm">
            <table id="dataTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>اسم العميل</th>
                    <th>رقم العملية</th>
                    <th>المبلغ</th>
                    <th class="d-print-none">تسديد دين</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($debts as $item)
                    <tr>
                        <td>{{$item->customer->name}}</td>
                        <td><a href="{{route('order',$item->order_number)}}">ط{{$item->order_number}}</a></td>
                        <td class="cost">{{$item->cost}}</td>
                        <td class="d-print-none">
                            <a href="{{route('pay.debt',$item->id)}}" class="btn btn-info">تسديد <i class="fa fa-check-square-o"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2"><b>المجموع</b></td>
                    <td class="final-sum" colspan="1"><b>0</b></td>
                    <td class="d-print-none" style="border-right: 0;"></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <br>
        <center>
            <button type="button" class="btn btn-success" id="print">طباعة <i class="fa fa-print"></i></button>
        </center>
    </div>

    <!-- Modal -->

    {{--    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
    {{--        <div class="modal-dialog">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات الموزع</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <div class="alert alert-danger alert-dismissible fade show ajax-error-hide"--}}
    {{--                         style="display: none; width: 100%;" role="alert">--}}
    {{--                        <span class="ajax-error"></span>--}}
    {{--                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
    {{--                            <span aria-hidden="true">&times;</span>--}}
    {{--                        </button>--}}
    {{--                        <br>--}}
    {{--                    </div>--}}
    {{--                    <form method="post" action="{{route('edit.companies')}}">--}}
    {{--                        @csrf--}}
    {{--                        <input id="id" value="" type="hidden" class="form-control" name="id" autocomplete="off">--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label for="name">اسم الموزع</label>--}}
    {{--                            <input id="name" value="" type="text" class="form-control"--}}
    {{--                                   placeholder="اسم الموزع" name="name" autocomplete="off">--}}
    {{--                        </div>--}}
    {{--                        @error('name')--}}
    {{--                        <small class="form-text text-danger">{{$message}}</small>--}}
    {{--                        @enderror--}}
    {{--                        <div class="form-group hide-quantity">--}}
    {{--                            <label for="number">رقم الموزع</label>--}}
    {{--                            <input id="number" value="" type="text" class="form-control"--}}
    {{--                                   placeholder="رقم الموزع" name="number" autocomplete="off">--}}
    {{--                        </div>--}}
    {{--                        @error('number')--}}
    {{--                        <small class="form-text text-danger">{{$message}}</small>--}}
    {{--                        @enderror--}}
    {{--                        <div class="form-group">--}}
    {{--                            <label for="alternative_number">رقم اخر ان وجد</label>--}}
    {{--                            <input id="alternative_number" value="" type="text" class="form-control"--}}
    {{--                                   placeholder="رقم اخر ان وجد" name="alternative_number" autocomplete="off">--}}
    {{--                        </div>--}}
    {{--                        @error('alternative_number')--}}
    {{--                        <small class="form-text text-danger">{{$message}}</small>--}}
    {{--                        @enderror--}}
    {{--                        <br>--}}
    {{--                        <center>--}}
    {{--                            <button type="submit" class="btn btn-primary">تعديل</button>--}}
    {{--                        </center>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--                <div class="modal-footer">--}}
    {{--                    <button type="button" class="btn btn-danger" data-dismiss="modal">غلق</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
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
    <script src="{{asset('print/printThis.js')}}"></script>
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
            // let info = $('.info').html();
            //
            // let newWin = window.open('', 'Print-Window');
            //
            // newWin.document.open();
            //
            // newWin.document.write('<html dir="rtl"><body onload="window.print()"><style>.d-print-none{display:none;} table{width: 100%;} table, th, td {border: 1px solid black;border-collapse: collapse; direction:rtl; text-align-last: center;}</style>' + divToPrint.innerHTML + '</body></html>');
            //
            // newWin.document.close();
            //
            // setTimeout(function () {
            //     newWin.close();
            // }, 10);
            $('.col-sm-12').eq(2).printThis({
                importCSS: true,
                importStyle: true
            });

        });
    </script>
    <x-data-table-filter-component/>
@endpush
