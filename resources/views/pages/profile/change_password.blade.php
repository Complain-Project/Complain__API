@extends('pages.profile')
@section('children')
    <section class="change__password__wrap">
        <section class="header__wrap">
            <span class="title">Đổi mật khẩu</span>
        </section>

        <form id="change-password-form" method="POST" action="{{ route('profile.update-password') }}">
            @csrf
            <section class="content__wrap">
                <article>
                    <div class="info__item">
                        <label class="form-label">Mật khẩu cũ</label>
                        <div class="input__wrap">
                            <span class="error--message">
                                @error('old_password')
                                {{ $message }}
                                @enderror
                            </span>

                            <input
                                type="password" name="old_password" value="{{ old('old_password') }}"
                                class="form-control input--password" placeholder="Nhập mật khẩu cũ">
                            <img src="/images/profile/eye_on.svg" alt="icon show password" class="show__password d-none">
                            <img src="/images/profile/eye_off.svg" alt="icon hide password" class="hide__password d-none">
                        </div>
                    </div>
                    <div class="info__item">
                        <label class="form-label">Mật khẩu mới</label>
                        <div class="input__wrap">
                            <span class="error--message">
                                @error('new_password')
                                {{ $message }}
                                @enderror
                            </span>

                            <input
                                type="password" name="new_password" value="{{ old('new_password') }}"
                                class="form-control input--password" placeholder="Nhập mật khẩu mới">
                            <img src="/images/profile/eye_on.svg" alt="icon show password" class="show__password d-none">
                            <img src="/images/profile/eye_off.svg" alt="icon hide password" class="hide__password d-none">
                        </div>
                    </div>
                    <div class="info__item">
                        <label class="form-label">Nhập lại mật khẩu mới</label>
                        <div class="input__wrap">
                            <span class="error--message">
                                @error('confirm_password')
                                {{ $message }}
                                @enderror
                            </span>

                            <input
                                type="password" name="confirm_password" value="{{ old('confirm_password') }}"
                                class="form-control input--password" placeholder="Nhập lại mật khẩu mới">
                            <img src="/images/profile/eye_on.svg" alt="icon show password" class="show__password d-none">
                            <img src="/images/profile/eye_off.svg" alt="icon hide password" class="hide__password d-none">
                        </div>
                    </div>
                </article>
            </section>

            <section class="footer__wrap">
                <button type="button" class="btn__action btn btn-danger" id="submit-form">Lưu lại</button>
                <a href="{{ route('home') }}" type="button" class="btn__action btn btn-outline-danger">Hủy bỏ</a>
            </section>
        </form>
    </section>
@endsection
