@php
    use App\Models\Clients\Complain;
    use Illuminate\Support\Carbon;
@endphp

@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/home/_home.css') }}">
@endsection

@section('script')
    <script src="{{ mix('/js/home/_home.js') }}"></script>
@endsection

@section('content')
    <section class="home">
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
                    @else
                    <div class="main-title">
                        Lịch sử khiếu nại của bạn
                    </div>

                    <div class="form-group">
                        <form action="{{route('history')}}" method="GET">
                            <div class="input-form d-flex">
                                <select name="district" id="district_id"
                                        data-code="{{$district}}"
                                        class="form-control me-2 w-50">
                                    <option selected>Chọn cơ quan tiếp nhận</option>
                                </select>
                                <input type="text" id="search" name="q" value="{{ $q }}" class="form-control"
                                       placeholder="Nhập mã số / Tiêu đề khiếu nại để tìm kiếm">
                                <button type="submit" class="btn btn-search btn-main">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>

                    @if($q)
                        <div class="main-title result">
                            Có {{count($complains)}} kết quả cho từ khóa "<b>{{$q}}</b>"
                        </div>
                    @endif

                    @if(count($complains) == 0)
                        <div class="main-title result text-center mt-5">
                            Không có kết quả nào phù hợp.
                        </div>
                    @endif

                    <div class="list-complain">
                        @foreach($complains as $complain)
                            <div class="item">
                                <a href="{{route('complain.detail', [$complain->_id])}}" class="icon">
                                    <img src="/images/loai-quydinh.svg" alt="">
                                </a>

                                <div class="content">
                                    @php
                                        $date = Carbon::parse($complain['created_at'])->timezone('Asia/Ho_Chi_Minh')
                                    @endphp
                                    <div class="post-info">
                                        {{Auth::guard('clients')->id() === $complain->user_id ? $complain->user->name : $complain->user->aliases}}
                                        - {{$date->format('m:h') . ' ngày ' . $date->format(' d/m/Y')}}

                                        @if($complain->status === Complain::STATUS['PROCESSED'])
                                            <span class="status replied">Đã trả lời</span>
                                        @else
                                            <span class="status noanswer">Chưa trả lời</span>
                                        @endif
                                    </div>
                                    <h3 class="post-title">
                                        <a href="{{route('complain.detail', [$complain->_id])}}" class="">Phản ánh kiến nghị về: {{$complain->title}}</a>
                                    </h3>
                                    <p style="text-align: justify;" class="post-shortdesc">Nội dung kiến nghị: {{$complain->content}}</p>
                                </div>
                            </div>
                        @endforeach
                        <div class="pagination-wrap">
                            {{$complains->onEachSide(1)->links('vendor.pagination.custom-pagination')}}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
