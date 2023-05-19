@php use Illuminate\Support\Facades\Auth; @endphp
<div class="container d-flex align-items-center justify-content-between">
    <div class="position-relative">
        <div class="logo-text">
            <a href="{{route('home')}}" class="logo">
                <img src="/images/logo.svg" alt="">
            </a>
        </div>
    </div>
    <ul class="float-start menus">
        <li class="{{getActiveMenuClass('home')}}" id="home-page">
            <a href="{{route('home')}}">
                Trang chủ
            </a>
        </li>
        <li class="{{getActiveMenuClass('complain.form')}}">
            <a href="{{route('complain.form')}}">Gửi yêu cầu / khiếu nại</a>
        </li>
        <li class="{{getActiveMenuClass('history')}}">
            <a href="{{route('history')}}">Lịch sử khiếu nại</a>
        </li>
        <li class="{{getActiveMenuClass('posts')}}">
            <a href="{{route('posts')}}">Bài viết</a>
        </li>
        @if(Auth::guard('clients')->check())
            <li class="{{getActiveMenuClass(['profile.personal-information', 'profile.change-password'])}}">
                <a href="{{route('profile.personal-information')}}">Thông tin cá nhân</a>
            </li>
        @else
            <li><a href="{{route('registerForm')}}" class="btn btn-register ml-10">Đăng ký</a></li>
            <li><a href="{{route('loginForm')}}" class="btn btn-login">Đăng nhập</a></li>
        @endif
    </ul>
</div>
