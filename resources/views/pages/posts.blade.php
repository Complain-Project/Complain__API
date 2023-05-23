@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Carbon;
@endphp
@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ mix('/css/post/_post.css') }}">
@endsection

@section('script')
<script src="{{ mix('/js/post/_post.js') }}"></script>
@endsection

@section('content')
<section class="post">
    <div class="container">
        <div class="content">
            <div class="form-group">
                <form action="{{route('posts')}}" method="GET">
                    <div class="input-form d-flex">
                        <input type="text" onfocus="(this.type='date')"
                               name="date" placeholder="Chọn ngày tạo"
                               value="{{old('date', $date)}}"
                               class="form-control date">
                        <input type="text" id="search" name="q" value="{{ $q }}" class="form-control"
                               placeholder="Nhập tiêu đề bài viết để tìm kiếm">
                        <button type="submit" class="btn btn-search btn-main">Tìm kiếm</button>
                    </div>
                </form>
            </div>

            @if($q)
                <div class="main-title result">
                    Có {{count($posts)}} kết quả cho từ khóa "<b>{{$q}}</b>"
                </div>
            @endif

            @if(count($posts) == 0)
                <div class="main-title result text-center mt-5">
                    Không có kết quả nào phù hợp.
                </div>
            @endif

            <div class="list-post">
                <div class="row post-wrapper">
                    @foreach($posts as $post)
                        <div class="col-6 post-wrapper__box">
                            <div class="row">
                                <div class="col-5">
                                    <a href="{{route('post.detail', [$post->slug])}}">
                                        <img class="post-wrapper__image" src="{{$post->banner_src}}" alt="">
                                    </a>
                                    @php
                                        $date = Carbon::parse($post->created_at)->timezone('Asia/Ho_Chi_Minh')->format('H:i d/m/Y')
                                    @endphp
                                    <div class="post-wrapper__create">
                                        <i>Ngày tạo: {{$date}}</i>
                                    </div>
                                </div>
                                <div class="col-7 post-wrapper__box">
                                    <a href="{{route('post.detail', [$post->slug])}}">
                                        <p class="post-wrapper__title">{{Str::limit($post->title, 55, '...')}}</p>
                                    </a>
                                    <p class="post-wrapper__short">{{$post->short_content}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{$posts->onEachSide(1)->links('vendor.pagination.custom-pagination')}}
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
