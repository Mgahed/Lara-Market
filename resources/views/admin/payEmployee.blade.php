@extends('layouts.admin')
@section('admin-content')
    <div class="container-fluid mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card mb-5">
                    <div class="card-header">{{ __('تسجيل عامل جديد') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('pay.user')}}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('الاسم') }}</label>

                                <div class="col-md-6">
                                    <select id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            required>
                                        @foreach ($users as $user)
                                            <option value="{{$user->name}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price"
                                       class="col-md-4 col-form-label text-md-right">{{ __('المبلغ') }}</label>

                                <div class="col-md-6">
                                    <input id="price" type="text"
                                           class="form-control @error('price') is-invalid @enderror" name="price"
                                           value="{{ old('price') }}" required autocomplete="off">

                                    @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <center>
                                <button type="submit" class="btn btn-primary">دفع</button>
                            </center>
                        </form>
                    </div>

                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
@endsection
