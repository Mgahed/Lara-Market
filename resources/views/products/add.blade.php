@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-2">
                <div class="card">
                    <div class="card-header">{{ __('اضافة منتج') }}</div>

                    <div class="card-body">
                        @if (session('success1'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{session('success1')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (session('fail1'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{session('fail1')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="post" action="{{route('add.products')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">حجم المنتج</label>
                                <select name="size" class="form-control select" id="exampleFormControlSelect1">
                                    <option value="s">فرط</option>
                                    <option value="m">علبة</option>
                                    <option value="l">كرتونة</option>
                                </select>
                            </div>
                            @error('size')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group">
                                <label for="barcode">الباركود</label>
                                <input id="barcode" value="{{old('barcode')}}" type="text" class="form-control"
                                       placeholder="الباركود" name="barcode" autofocus autocomplete="off">
                            </div>
                            @error('barcode')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group">
                                <label for="name">اسم المنتج</label>
                                <input id="name" value="{{old('name')}}" type="text" class="form-control"
                                       placeholder="اسم المنتج" name="name" autocomplete="off">
                            </div>
                            @error('name')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group">
                                <label for="category">التصنيف</label>
                                <input id="category" value="{{old('category')}}" list="categoryList" type="text"
                                       class="form-control" placeholder="التصنيف" name="category" autocomplete="off">
                                <datalist id="categoryList">
                                    @foreach ($products as $product)
                                        <option value="{{$product->category}}">
                                    @endforeach
                                </datalist>
                            </div>
                            @error('category')
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
                            <br>
                            <center>
                                <p class="hide" style="font-size: 15px;display:none;color: red;">يجب ان يكون سعر البيع
                                    اكبر من سعر الشراء و ان يكونا اكبر من 0</p>
                                <br>
                                <button type="submit" class="btn btn-primary notallowed">اضافة</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @if (session('success2'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success2')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('fail2'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('fail2')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card hide-card2" style="display:none;">
                    <div class="card-header">{{ __('ربط العلبة بالفرط') }}</div>
                    <div class="card-body">
                        <form method="post" action="{{route('add.product.size.m')}}">
                            @csrf
                            <input type="hidden" name="size" value="m">
                            <div class="form-group">
                                <label for="barcode11">باركود الفرط</label>
                                <input id="barcode11" type="text" name="barcodes" class="form-control"
                                       placeholder="الباركود">
                            </div>
                            <div class="form-group">
                                <label for="barcode1">باركود العلبة</label>
                                <input id="barcode1" type="text" name="barcodem" class="form-control"
                                       placeholder="الباركود">
                            </div>
                            <div class="form-group">
                                <label for="quantity1">الكمية في العلبة</label>
                                <input id="quantity1" type="text" name="quantity" class="form-control"
                                       placeholder="الكمية">
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary">ربط</button>
                            </center>
                        </form>
                    </div>
                </div>

                @if (session('success3'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success3')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session('fail3'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{session('fail3')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card hide-card3" style="display:none;">
                    <div class="card-header">{{ __('ربط الكرتونة بالعلبة') }}</div>
                    <div class="card-body">
                        <form method="post" action="{{route('add.product.size.l')}}">
                            @csrf
                            <input type="hidden" name="size" value="l">
                            <div class="form-group">
                                <label for="barcode21">باركود العلبة</label>
                                <input id="barcode21" type="text" name="barcodem" class="form-control" placeholder="الباركود">
                            </div>
                            <div class="form-group">
                                <label for="barcode2">باركود الكرتونة</label>
                                <input id="barcode2" type="text" name="barcodel" class="form-control" placeholder="الباركود">
                            </div>
                            <div class="form-group">
                                <label for="quantity2">الكمية في الكرتونة</label>
                                <input id="quantity2" type="text" name="quantity" class="form-control" placeholder="الكمية">
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary">ربط</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('bottom-script')
        <script>
            $('.select').on('change', function () {
                $('.hide-card3').css('display', 'none');
                if (this.value !== 's') {
                    $('.hide-card2').css('display', 'block');
                    $('.hide-quantity').css('display', 'block');
                    let barcode = $('#barcode').val()
                    $('#barcode1').val(barcode)
                } else {
                    $('.hide-card2').css('display', 'none');
                    $('.hide-quantity').css('display', 'none');
                }
                if (this.value === 'l') {
                    $('.hide-card2').css('display', 'none');
                    $('.hide-card3').css('display', 'block');
                    let barcode = $('#barcode').val()
                    $('#barcode2').val(barcode)
                }
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
        </script>
    @endpush
@endsection
