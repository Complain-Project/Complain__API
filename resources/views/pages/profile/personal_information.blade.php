@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::guard('clients')->user();
@endphp
@extends('pages.profile')
@section('children')
    <div class="information-wrap">
        <div class="header-wrap">
            <span class="title">Chỉnh sửa thông tin cá nhân</span>
        </div>
        <div class="form-wrap">
            <form method="POST" action="{{ route('profile.update-info') }}" class="form" id="form-info">
                @csrf
                <div class="input-wrap">
                    <label class="title">Họ và tên <span class="required">*</span></label></label>

                    <span class="error--message">
                        @error('name')
                        {{ $message }}
                        @enderror
                    </span>

                    <input type="text" placeholder="Nhập họ và tên" class="input__info"
                           name="name" value="{{ old('name') ?: $user->name }}">
                </div>

                <div class="input-wrap">
                    <label class="title">Bí danh <span class="required">*</span></label></label>

                    <span class="error--message">
                        @error('aliases')
                        {{ $message }}
                        @enderror
                    </span>

                    <input type="text" placeholder="Nhập bí danh" class="input__info"
                           name="aliases" value="{{ old('aliases') ?: $user->aliases }}">
                </div>

                <div class="input-wrap">
                    <label class="title">Số điện thoại <span class="required">*</span></label></label>

                    <span class="error--message">
                        @error('phone')
                        {{ $message }}
                        @enderror
                    </span>

                    <input type="text" placeholder="Nhập số điện thoại" class="input__info" name="phone"
                           value="{{ old('phone') ?: $user->phone }}">
                </div>

                <div class="input-wrap">
                    <label class="title">Email</label>
                    <input type="email" placeholder="Nhập email" name="email"
                           value="{{ old('email') ?: $user->email }}">
                </div>

                <div class="input-wrap">
                    <label class="title">Ngày sinh</label>
                    <input type="date" placeholder="Nhập ngày sinh" name="birthday"
                           value="{{ old('birthday', Carbon::createFromTimestamp($user->birthday)->format('Y-m-d')) }}">
                </div>
                <div class="btn-wrap mt-4">
                    <button type="button" class="btn btn-primary btn-save-information">Lưu thông tin</button>
                </div>
            </form>
        </div>
    </div>
@endsection
