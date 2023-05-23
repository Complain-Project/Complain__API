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

                <div class="main-title">
                    Tra cứu kết quả trả lời
                </div>

                <div class="form-group">
                    <form action="{{route('home')}}" method="GET">
                        <div class="input-form d-flex">
                            <input type="text" onfocus="(this.type='date')"
                                   name="date" placeholder="Chọn ngày tạo"
                                   value="{{old('date', $date)}}"
                                   class="form-control date me-2">
                            <select name="district" id="district_id"
                                    data-code="{{$district}}"
                                    class="form-control district me-2">
                                <option selected>Chọn cơ quan tiếp nhận</option>
                            </select>
                            <input type="text" id="search" name="q" value="{{ $q }}" class="form-control search"
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
                                    {{$complain->user->aliases}}
                                    - {{$date->format('m:h') . ' ngày ' . $date->format(' d/m/Y')}}

                                    @if($complain->status === Complain::STATUS['PROCESSED'])
                                        <span class="status replied">Đã trả lời</span>
                                    @else
                                        <span class="status noanswer">Chưa trả lời</span>
                                    @endif
                                </div>
                                <h3 class="post-title">
                                    <a href="{{route('complain.detail', [$complain->_id])}}" class="">
                                        Phản ánh kiến nghị về: {{$complain->title}}
                                    </a>
                                </h3>
                                <p style="text-align: justify;" class="post-shortdesc">Nội dung kiến
                                    nghị: {{$complain->content}}</p>
                            </div>
                        </div>
                    @endforeach
                    <div class="pagination-wrap">
                        {{$complains->onEachSide(1)->links('vendor.pagination.custom-pagination')}}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
