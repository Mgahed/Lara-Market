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
        <div class="table-responsive-sm">
            <table id="dataTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>اسم العامل</th>
                    <th>اسم العميل</th>
                    <th>التاريخ</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td><a href="{{route('order',$item->order_number)}}">ط{{$item->order_number}}</a></td>
                        <td>{{$item->user->name}}</td>
                        <td>{{$item->customer->name}}</td>
                        <td>{{date('Y-m-d -- h:i A', strtotime($item->updated_at))}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
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
            let o400 = new Option("option text", "5000000");
            $(o400).html("الكل");
            setTimeout(function () {
                $("select[name='dataTable_length']").append(o400);
            }, 100)
        });
    </script>
@endpush
