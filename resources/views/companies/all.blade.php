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
                    <th>اسم الموزع</th>
                    <th>رقم الموزع</th>
                    <th>رقم اخر</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($companies as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td><a href="tel:{{$item->number}}">{{$item->number}}</a></td>
                        <td>
                            @if ($item->alternative_number)
                                <a href="tel:{{$item->alternative_number}}">{{$item->alternative_number}}</a>
                            @else
                                <span class="text-danger">لا يوجد</span>
                            @endif
                        </td>
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
    <script type="text/javascript" src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
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
