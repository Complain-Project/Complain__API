@php
    use Illuminate\Support\Carbon;
@endphp
@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/post/_detail.css') }}">
@endsection

@section('script')
    <script src="{{ mix('/js/post/_post.js') }}"></script>
@endsection

@section('content')
    <section class="post">
        <div class="container">
            <div class="content">
                <div class="content_banner">
                    <img src="{{$post->banner_src}}" alt="">
                </div>
                <div class="content_body">
                    <div class="content_body__title">
                        {{$post->title}}
                    </div>
                    @php
                        $date = Carbon::parse($post['created_at'])->format('h:m d/m/Y')
                    @endphp
                    <div class="content_body__author">
                        {{$post->author->name}}
                        <i class="fa fa-circle"></i>
                        <span>Ngày tạo: {{$date}}</span>
                    </div>
                    <div class="content_body__short">
                        {!! $post->short_content !!}
                    </div>
                    <div class="content_body__content">
                        {!! $post->content !!}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
