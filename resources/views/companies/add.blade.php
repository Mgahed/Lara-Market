@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-header">{{ __('اضافة موزع') }}</div>

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

                        <form method="post" action="{{route('add.companies')}}">
                            @csrf
                            <div class="form-group">
                                <label for="name">اسم الموزع</label>
                                <input id="name" value="{{old('name')}}" type="text" class="form-control"
                                       placeholder="اسم الموزع" name="name" autocomplete="off">
                            </div>
                            @error('name')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group hide-quantity">
                                <label for="number">رقم الموزع</label>
                                <input id="number" value="{{old('number')}}" type="text" class="form-control"
                                       placeholder="رقم الموزع" name="number" autocomplete="off">
                            </div>
                            @error('number')
                            <small class="form-text text-danger">{{$message}}</small>
                            @enderror
                            <div class="form-group">
                                <label for="alternative_number">رقم اخر ان وجد</label>
                                <input id="alternative_number" value="{{old('alternative_number')}}" type="text" class="form-control"
                                       placeholder="رقم اخر ان وجد" name="alternative_number" autocomplete="off">
                            </div>
                            @error('alternative_number')
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
