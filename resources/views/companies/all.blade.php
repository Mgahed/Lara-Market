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
                    <th>اسم الموزع</th>
                    <th>رقم الموزع</th>
                    <th>رقم اخر</th>
                    <th>العمليات</th>
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
                        <td>
                            <button type="button" onclick="my_ajax({{$item->id}})" class="btn btn-success"
                                    data-toggle="modal" data-target="#exampleModal">
                                تعديل <i class="fa fa-pencil"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات الموزع</h5>
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
                    <form method="post" action="{{route('edit.companies')}}">
                        @csrf
                        <input id="id" value="" type="hidden" class="form-control" name="id" autocomplete="off">
                        <div class="form-group">
                            <label for="name">اسم الموزع</label>
                            <input id="name" value="" type="text" class="form-control"
                                   placeholder="اسم الموزع" name="name" autocomplete="off">
                        </div>
                        @error('name')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <div class="form-group hide-quantity">
                            <label for="number">رقم الموزع</label>
                            <input id="number" value="" type="text" class="form-control"
                                   placeholder="رقم الموزع" name="number" autocomplete="off">
                        </div>
                        @error('number')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <div class="form-group">
                            <label for="alternative_number">رقم اخر ان وجد</label>
                            <input id="alternative_number" value="" type="text" class="form-control"
                                   placeholder="رقم اخر ان وجد" name="alternative_number" autocomplete="off">
                        </div>
                        @error('alternative_number')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <br>
                        <center>
                            <button type="submit" class="btn btn-primary">تعديل</button>
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

        function my_ajax(id) {
            $.ajax({
                type: 'get',
                url: "{{route('edit.companies.view')}}",
                data: {
                    id: id
                },
                success: function (data) {
                    if (data.error) {
                        $('.ajax-error').text(data.error);
                        $('.ajax-error-hide').css('display', 'inline-block')
                    } else {
                        // console.log(data);
                        $('input[name="name"]').val(data.name);
                        $('input[name="id"]').val(data.id);
                        $('input[name="number"]').val(data.number);
                        $('input[name="alternative_number"]').val(data.alternative_number);
                    }
                },
                error: function (reject) {
                    let a_errors = reject.responseJSON.errors;
                    console.log(a_errors);
                },
            });
        }
    </script>
@endpush
