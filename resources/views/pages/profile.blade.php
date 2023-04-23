@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/profile/_profile.css') }}">
@endsection

@section('script')
    <script src="{{ mix('/js/profile/_profile.js') }}"></script>
@endsection

@section('content')
    <section class="profile">
        <div class="container">
            <div class="row me-0 content">
                <div class="col-4 menu-wrap item-row">
                    <div class="header-wrap">
                        <div class="image-wrap">
                            <img src="/images/profile/user.svg" alt="icon user" id="action-upload">
                        </div>
                        <div class="text-header">
                            <p>Xin chào,</p>
                            <p class="name">{{Auth::guard('clients')->user()->name }}</p>
                        </div>
                    </div>

                    <div class="menu-nav-wrap">
                        <ul>
                            <li class="item-wrap">
                                <div class="img-wrap">
                                    <img src="/images/profile/edit.svg" alt="icon edit info">
                                </div>
                                <a class="text {{ getActiveMenuClass(['profile.personal-information']) }}"
                                   href="{{ route('profile.personal-information') }}">Chỉnh sửa thông tin cá nhân</a>
                            </li>
                            <li class="item-wrap">
                                <div class="img-wrap">
                                    <img src="/images/profile/unlocked.svg" alt="icon change password">
                                </div>
                                <a class="text {{ getActiveMenuClass(['profile.change-password']) }}"
                                   href="{{ route('profile.change-password') }}">Đổi mật khẩu</a>
                            </li>
                            <li class="item-wrap">
                                <div class="img-wrap">
                                    <img src="/images/profile/logout.svg" alt="icon logout">
                                </div>
                                <a class="text" href="{{Route('logout')}}">Đăng xuất</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-8 pe-0 content-children item-row">
                    @yield('children')
                </div>
            </div>
        </div>
    </section>
@endsection
