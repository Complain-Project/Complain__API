@extends('layouts.auth')

@section('script')
    <script src="{{ mix('/js/home/_home.js') }}"></script>
@endsection

@section('content')
    <div class="container col-xs-4 col-sm-4 col-md-4 col-lg-4 col-12
                 col-centered wr-content pt-3 mb-5 main-container">

        <form action="{{route('login')}}" method="post" id="loginForm">
            @csrf
            <div id="loginStep">
                <div class="col text-center">
                    <h6 class="title"
                        style="color: #1E2F41; font-size: 26px; line-height: 32px;">
                        Đăng nhập</h6>
                </div>
            </div>
            <div class="box-login">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập <span class="required">*</span></label>
                    <input type="text" class="form-control" value="{{old('username')}}" name="username" id="username" placeholder="Nhập CMT/CCCD hoặc số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu <span class="required">*</span></label>
                    <input type="password" class="form-control" value="{{old('password')}}" name="password" id="password" placeholder="Nhập mật khẩu">
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-submit w-50 mt-2">Đăng nhập</button>
                </div>
            </div>
        </form>
        <!-- /content/body -->
        <div class="col text-center pt-2 pb-2 text-normal-2">
            <a>Chưa có tài khoản?</a>
            <a class="text-cam" href="{{route('registerForm')}}">
                Đăng ký
            </a>
        </div>
    </div>
@endsection