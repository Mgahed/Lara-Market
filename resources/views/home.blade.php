@extends('layouts.app')

@section('content')
    <div class="container">
        <center>
            <a href="{{route('sell.new.products')}}" class="btn btn-info">عملية بيع جديدة <i
                    class="fa fa-plus-square-o"></i></a>
        </center>
        <div class="row justify-content-center">
            <div class="col-md-4 mt-2">
                <div class="card">
                    <div class="card-header">{{ __('العمليات الحالية') }}</div>

                    <div class="card-body">
                        @foreach ($pending_orders as $order)
                            <a href="{{route('sell.old.products',$order[0]->order_number)}}">العملية رقم: <span
                                    class="text-danger">{{$order[0]->order_number}}</span></a>
                            <div>بعض المنتجات: <span class="text-danger">
                                    @php($i = 0)
                                    @foreach ($order as $item)
                                        <small style="white-space: nowrap;">
                                            {{$item->quantity}}.x{{$item->product->name}}
                                        </small>
                                        @php($i++)
                                        @if ($i > 1)
                                            @break
                                        @endif
                                    @endforeach
                            </span></div>
                            <br>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-5 mt-2">
                <div class="card">
                    <div class="card-header">{{ __('عملية بيع') }}</div>

                    <div class="card-body">

                        <div class="alert alert-danger add-product-danger" style="display: none;" role="alert"></div>

                        <form id="form-add-product">
                            @csrf
                            <input class="sell_order_id" type="hidden" name="order_id"
                                   value="{{$first_order?$first_order[0]->order_number:'none'}}">
                            <div class="row">
                                <div class="col">
                                    <input id="focus" type="text" name="barcode" class="form-control"
                                           placeholder="الباركود"
                                           autofocus>
                                </div>
                                <div class="col">
                                    <input type="number" name="quantity" class="form-control quantity"
                                           placeholder="الكمية"
                                           value="1">
                                </div>
                            </div>
                            <br>
                            <center>
                                <button id="submit-form-add-product" type="submit" class="btn btn-primary">اضافة <i
                                        class="fa fa-cart-plus"></i>
                                </button>
                            </center>
                        </form>
                        <hr>
                        <hr>

                        @if (session('fail'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{session('fail')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <h5 class="m-3 text-center">ازالة منتج</h5>
                        <form method="post" action="{{route('remove.products')}}">
                            @csrf
                            <input class="sell_order_id" type="hidden" name="order_id"
                                   value="{{$first_order?$first_order[0]->order_number:'none'}}">
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="barcode2" class="form-control" placeholder="الباركود"
                                           autofocus>
                                </div>
                                <div class="col">
                                    <input type="number" name="quantity" class="form-control quantity"
                                           placeholder="الكمية" value="1">
                                </div>
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-danger">ازالة <i class="fa fa-trash"></i></button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-2">
                @if (session('fail2'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('fail2')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex mt-2">
                            <span>
                                {{ __('منتجات العملية') }} <span
                                    class="text-danger"
                                    id="products_of_current_order">{{$first_order?$first_order[0]->order_number:'الجديدة'}}</span>
                            </span>
                            <div class="ml-auto"><a
                                    href="{{route('delete.order',$first_order?$first_order[0]->order_number:'الجديدة')}}"
                                    class="btn btn-sm btn-outline-danger delete-order">مسح الطلب</a></div>
                        </div>
                    </div>
                    <div class="card-body" id="ndhtml">
                        @php($sum=0)
                        @if ($first_order)
                            @foreach ($first_order as $order)
                                <div class="d-flex">
                                    <span>{{$order->quantity}}.x {{$order->product->name}}</span>
                                    <div class="ml-auto">{{$order->product->price_of_sell * $order->quantity}}</div>
                                </div>
                                <hr style="margin-bottom: 0; border-color: rgba(0, 0, 0, .3);">
                                @php($sum+=$order->product->price_of_sell * $order->quantity)
                            @endforeach
                            <div class="d-flex mt-2">
                                <span>المجموع</span>
                                <div class="ml-auto">{{$sum}}</div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <form method="POST" action="{{route('final.order')}}">
                            @csrf
                            <input class="sell_order_id" type="hidden" name="order_id"
                                   value="{{$first_order?$first_order[0]->order_number:'none'}}">
                            <input type="text" class="form-control" name="customer_name" placeholder="اسم العميل"
                                   list="customers">
                            <datalist id="customers">
                                @foreach ($customers as $customer)
                                    <option value="{{$customer->name}}">
                                @endforeach
                            </datalist>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-success">تأكيد</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('bottom-script')
    <script>
        $('#submit-form-add-product').click(function (e) {
            e.preventDefault();
            let formData = new FormData($('#form-add-product')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('sell.products')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.fail) {
                        $('.add-product-danger').css('display', 'block');
                        $('.add-product-danger').text(data.fail);
                        $('.quantity').val("1");
                        document.getElementById("focus").focus();
                    } else {
                        $('.add-product-danger').css('display', 'none');
                        $('.sell_order_id').val(data.order_number);
                        $('.delete-order').attr('href', '/sell/delete/' + data.order_number);
                        $('#products_of_current_order').text(data.order_number);
                        $('#focus').val("");
                        $('.quantity').val("1");
                        document.getElementById("focus").focus();

                        $('#ndhtml').html(data.ndhtml);
                    }
                    console.log(data);
                },
                error: function (reject) {
                    var a_errors = reject.responseJSON.errors;
                    console.log(a_errors);
                },
            });
        });
    </script>
@endpush
