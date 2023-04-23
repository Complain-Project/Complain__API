@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/complain/_submit_complain.css') }}">
@endsection

@section('script')
    <script src="{{ mix('/js/complain/_submit_complain.js') }}"></script>
@endsection

@section('content')
    <section class="complain">
        <div class="container">
            <div class="content">
                @if(!Auth::guard('clients')->check())
                    <div class="no-auth">
                        <!--begin::Alert-->
                        <div class="alert alert-dismissible alert-show d-flex flex-column align-items-center flex-sm-row p-3 mb-10">
                            <!--begin::Icon-->
                            <span class="fa-solid fa-circle-exclamation fa-xl me-3 mb-5 mb-sm-0"
                                  style="color: #f2994a;"></span>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                                <!--begin::Content-->
                                <div class="mess">
                                    Vui lòng
                                    <a href="{{route('login')}}"><u><i>đăng nhập </i></u></a> tài khoản để gửi phản ánh,
                                    kiến
                                    nghị! Nếu chưa có vui lòng đăng ký
                                    <a href="{{route('register')}}"><u><i>tại đây</i></u></a>
                                </div>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Alert-->
                    </div>
                @endif
                <div class="box-form-wrapper">
                    <div class="main-title">
                        Tiếp nhận khiếu nại
                    </div>
                    <div class="box-form">
                        <form id="submit_complain" action="{{route('complain.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row mb-3">
                                <div class="col-sm-3 col-xs-12 label-text control-label">
                                    Khiếu nại về việc
                                    <span class="required">*</span>
                                </div>
                                <div class="input col-sm-9 col-xs-12" id="title_1">
                                    <input id="title" name="title" type="text" class="form-control"
                                           placeholder="Nhập tiêu đề khiếu nại">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3 col-xs-12 label-text control-label">
                                    Nội dung
                                    <span class="required">*</span>
                                </div>
                                <div class="input col-sm-9 col-xs-12">
                                        <textarea id="content" name="content" type="text" class="form-control"
                                                  placeholder="Nhập nội dung" rows="5">
                                            {{old('content') ?: ''}}
                                        </textarea>
                                    <div style="color: red; font-style: italic">*Nội dung này sẽ được công khai. Vui lòng không ghi chi tiết thông tin cá nhân!</div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3 col-xs-12 label-text control-label">
                                    Chọn đơn vị tiếp nhận
                                    <span class="required">*</span>
                                </div>
                                <div class="input col-sm-9 col-xs-12">
                                    <select name="district_id" id="district_id"
                                            class="form-control">
                                        <option selected>Chọn cơ quan tiếp nhận</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3 col-xs-12 label-text control-label">
                                    Tài liệu đính kèm
                                </div>
                                <div class="input col-sm-9 col-xs-12">
                                    <input type="file" id="attachment" accept=".doc,.docx,.xlsx,.pdf" name="attachment">
                                    <ul id="fileList"></ul>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-sm-3 col-xs-12 label-text control-label">
                                </div>
                                <div class="input col-sm-9 col-xs-12">
                                    <button type="submit" id="btnSubmit" class="btn btn-submit me-3"> Gửi khiếu nại
                                    </button>
                                    <button id="btnReset" class="btn btn-reset" type="reset"> Nhập lại</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
