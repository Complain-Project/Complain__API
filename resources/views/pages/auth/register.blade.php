@extends('layouts.auth')

@section('script')
    <script src="{{ mix('/js/home/_home.js') }}"></script>
@endsection

@section('content')
    <div class="container col-xs-4 col-sm-4 col-md-4 col-lg-4 col-12
                 col-centered wr-content pt-3 mb-5 main-container">

        <form action="{{route('register')}}" method="post" id="registerForm">
            @csrf
            <div id="loginStep">
                <div class="col text-center">
                    <h6 class="title"
                        style="color: #1E2F41; font-size: 26px; line-height: 32px;">
                        Đăng ký</h6>
                </div>
            </div>
            <div class="box-login">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập <span class="required">*</span></label>
                    <input type="text" class="form-control" value="{{old('account_name')}}" name="account_name" id="username" placeholder="Nhập CMT/CCCD">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu <span class="required">*</span></label>
                    <input type="password" class="form-control" value="{{old('password')}}" name="password" id="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên <span class="required">*</span></label>
                    <input type="text" class="form-control" value="{{old('name')}}" name="name" id="name" placeholder="Nhập họ tên">
                </div>
                <div class="mb-3">
                    <label for="aliases" class="form-label">Bí danh <span class="required">*</span></label>
                    <input type="text" class="form-control" value="{{old('aliases')}}" name="aliases" id="aliases" placeholder="Nhập bí danh">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại <span class="required">*</span></label>
                    <input type="text" class="form-control" value="{{old('phone')}}" name="phone" id="phone" placeholder="Nhập số điện thoại">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" value="{{old('email')}}" name="email" id="email" placeholder="Nhập email">
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" value="{{old('birthday')}}" name="birthday" id="birthday" placeholder="Ngày sinh">
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-submit w-50 mt-2">Đăng ký</button>
                </div>
            </div>
        </form>
        <!-- /content/body -->
        <div class="col text-center pt-2 pb-2 text-normal-2">
            <a>Đã có tài khoản?</a>
            <a class="text-cam" href="{{route('loginForm')}}">
                Đăng nhập
            </a>
        </div>
    </div>
@endsection