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
        <div class="table-responsive-sm ">
            <table id="dataTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>الباركود</th>
                    <th>الكمية</th>
                    <th>سعر البيع</th>
                    <th>سعر الشراء</th>
                    <th>النوع</th>
                    <th class="">العمليات</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->barcode}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->price_of_sell}}</td>
                        <td>{{$product->price_of_buy}}</td>
                        <td>{{$product->category}}</td>
                        <td class="">
                            <button type="button" onclick="my_ajax({{$product->id}})" class="btn btn-success"
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
    <br>
    <center>
        <button type="button" class="btn btn-success" id="print">طباعة <i class="fa fa-print"></i></button>
    </center>

    <!-- Modal -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
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
                    <form method="post" action="{{route('edit.products')}}">
                        @csrf

                        <input id="id" value="" type="hidden" class="form-control" name="id" autocomplete="off">

                        <div class="form-group">
                            <label for="name">اسم المنتج</label>
                            <input id="name" value="{{old('name')}}" type="text" class="form-control"
                                   placeholder="اسم المنتج" name="name" autocomplete="off">
                        </div>
                        @error('name')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <div class="form-group hide-quantity">
                            <label for="quantity">الكمية</label>
                            <input id="quantity" value="0" type="number" class="form-control"
                                   placeholder="الكمية" name="quantity">
                        </div>
                        @error('quantity')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <div class="form-group">
                            <label for="buy">سعر الشراء</label>
                            <input id="buy" value="{{old('price_of_buy')}}" type="number" class="form-control"
                                   step="0.01"
                                   placeholder="سعر الشراء" name="price_of_buy">
                        </div>
                        @error('price_of_buy')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <div class="form-group">
                            <label for="sell">سعر البيع</label>
                            <input id="sell" value="{{old('price_of_sell')}}" type="number" class="form-control"
                                   step="0.01"
                                   placeholder="سعر البيع" name="price_of_sell" value="0">
                        </div>
                        @error('price_of_sell')
                        <small class="form-text text-danger">{{$message}}</small>
                        @enderror
                        <center>
                            <p class="hide" style="font-size: 15px;display:none;color: red;">يجب ان يكون سعر البيع
                                اكبر من سعر الشراء و ان يكونا اكبر من 0</p>
                            <br>
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
            let o400 = new Option("option text", "5000000");
            $(o400).html("الكل");
            setTimeout(function () {
                $("select[name='dataTable_length']").append(o400);
            }, 100)
        });

        $('input[name="price_of_sell"]').keyup(function () {
            var priceofbuy = $('input[name="price_of_buy"]').val();
            if (parseFloat($(this).val()) <= 0) {
                $(this).val(1);
            } else if (parseFloat($(this).val()) > parseFloat(priceofbuy)) {
                $(':input[type="submit"]').prop('disabled', false);
                $('.notallowed').removeClass('not-allowed');
                $('.hide').hide('slow');
            } else {
                $(':input[type="submit"]').prop('disabled', true);
                $('.notallowed').addClass('not-allowed');
                $('.hide').show('slow');
            }
        });
        $('input[name="price_of_buy"]').keyup(function () {
            var price = $('input[name="price_of_sell"]').val();
            if (parseFloat($(this).val()) <= 0) {
                $(this).val(1);
            } else if (parseFloat($(this).val()) < parseFloat(price)) {
                $(':input[type="submit"]').prop('disabled', false);
                $('.notallowed').removeClass('not-allowed');
                $('.hide').hide('slow');
            } else {
                $(':input[type="submit"]').prop('disabled', true);
                $('.notallowed').addClass('not-allowed');
                $('.hide').show('slow');
            }
        });
        $('input[name="quantity"]').keyup(function () {
            if (parseFloat($(this).val()) < 0) {
                $(this).val(1);
            }
        });

        function my_ajax(id) {
            $.ajax({
                type: 'get',
                url: "{{route('edit.products.view')}}",
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
                        $('input[name="quantity"]').val(data.quantity);
                        $('input[name="price_of_buy"]').val(data.price_of_buy);
                        $('input[name="price_of_sell"]').val(data.price_of_sell);
                    }
                },
                error: function (reject) {
                    let a_errors = reject.responseJSON.errors;
                    console.log(a_errors);
                },
            });
        }

        //print
        $('#print').click(function () {
            let divToPrint = $('.col-sm-12').eq(2)[0];
            // let info = $('.info').html();

            let newWin = window.open('', 'Print-Window');

            newWin.document.open();

            newWin.document.write('<html dir="rtl"><body onload="window.print()"><style>.hide{display:none;} table{width: 100%;} table, th, td {border: 1px solid black;border-collapse: collapse; direction:rtl; text-align-last: center;}</style>' + divToPrint.innerHTML + '</body></html>');

            newWin.document.close();

            setTimeout(function () {
                newWin.close();
            }, 10);

        });
    </script>
@endpush
