@extends('layouts.admin')

@section('admin-content')
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('تسجيل عامل جديد') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('الاسم') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('اسم المستخدم') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('كلمة المرور') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="text"
                                           class="paste-pass form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('تأكيد كلمة المرور') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="text" class="form-control paste-pass"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('تسجيل') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-dark gen-pass">اقتراح كلمة مرور</button>
                            </div>
                            <div class="col-md-6">
                                <div class="text text-danger pass" style="cursor: pointer;" title="ccc"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-danger text-center d-none">ملاحظة: برجاء حفظ كلمة المرور</div>
            </div>
        </div>
    </div>
@endsection
@push('bottom-script')
    <script>
        $('.gen-pass').click(function () {
            let password = Math.random().toString(36).slice(-10);
            $('.pass').html(password);
            $('.d-none').removeClass('d-none');
        });
        $('.pass').click(function () {
            let pass = $('.pass').text();
            $('.paste-pass').val(pass);
        })
    </script>
@endpush
