@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header">{{ __('اضافة مصروف') }}</div>

                    <div class="card-body">
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

                        <form method="post" action="{{route('add.other.expenses')}}">
                            @csrf
                            <div class="form-group">
                                <label for="expense_details">تفاصيل المصروف</label>
                                <textarea rows="5" id="expense_details" class="form-control"
                                          placeholder="تفاصيل المصروف" name="expense_details"
                                          autocomplete="off">{{old('expense_details')}}</textarea>
                            </div>
                            @error('expense_details')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group hide-quantity">
                                <label for="cost">التكلفة</label>
                                <input id="cost" value="{{old('cost')}}" type="number" class="form-control"
                                       placeholder="التكلفة" name="cost" autocomplete="off">
                            </div>
                            @error('cost')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <br>
                            <center>
                                <button type="submit" class="btn btn-primary">اضافة</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
