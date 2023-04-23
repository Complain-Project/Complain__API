@php
    use App\Models\Clients\Complain;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/complain/_detail.css') }}">
@endsection

@section('script')

@endsection

@section('content')
    <section class="detail">
        <div class="container">
            <div class="content">

                <div class="main-title">
                    Kiến nghị về việc: {{$complain->title}}
                </div>
                @php
                    $date = Carbon::parse($complain['created_at'])
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

                <div class="divider-gray"></div>

                <div class="list-complain">
                    <div class="item">
                        <a href="#" class="icon">
                            <img src="/images/loai-quydinh.svg" alt="">
                        </a>

                        <div class="content">
                            <p class="title">
                                Nội dung kiến nghị:
                            </p>
                            <p style="text-align: justify;" class="post-shortdesc">
                                {{$complain->content}}
                            </p>
                        </div>
                    </div>
                    <div class="divider-gray"></div>
                    <div class="item mt-5">
                        <a href="#" class="icon">
                            <img src="/images/messages.svg" alt="">
                        </a>

                        <div class="content">
                            @if($complain->reply || $complain->appointment_time)
                                <p class="title">
                                    Cơ quan chức năng trả lời:
                                </p>
                                <p style="text-align: justify;" class="post-shortdesc">
                                    {{$complain->reply}}
                                </p>
                                @else
                                <p class="title">
                                    Cơ quan chức năng chưa trả lời
                                </p>
                            @endif
                        </div>

                        @if($complain->appointment_time)
                            <i class="font-bold">Giấy hẹn:</i>

                            <div class="complain-reply">
                                <div class="time">
                                    <div style="margin: 0 200px;">
                                        <div style="text-align: center; font-weight: bold; font-size: 16px; margin-top: 20px;">
                                            <p>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</p>
                                            <p>Độc lập - Tự do - Hạnh phúc</p>
                                            <p>------------</p>
                                        </div>
                                        @php
                                            $time = Carbon::parse($complain->updated_at);
                                            $appointment_time = Carbon::parse($complain->updated_at)
                                        @endphp
                                        <p style="text-align: right; margin: 12px 0"><i>{{$complain->district->name}}, {{ $time->format('m:h') . ' ngày ' . $time->format(' d/m/Y') }}</i></p>
                                        <p style="text-align: center; font-size: 20px; font-weight: bold">THÔNG BÁO</p>
                                        <div style="font-size: 16px">
                                            <p style="text-align: center; font-weight: bold">Về việc thụ lý giải quyết khiếu nại {{$complain->code}}</p>
                                            <p style="margin-top: 32px">Kính gửi: Ông(Bà) {{$complain->user->name}}</p>
                                            <p>Địa chỉ: {{$complain->district->name}}</p>
                                            <p>Số CMND/CCCD: {{$complain->user->account_name}}</p>
                                            <p>Khiếu nại về việc: {{$complain->title}}</p>
                                            <p>Sau khi xem xét nội dung đơn khiếu nại, căn cứ Luật khiếu nại năm 2011, đơn khiếu nại đủ điều kiện thụ lý và thuộc thẩm quyền giải quyết của UBND {{$complain->district->name}}</p>
                                            <p>Đơn khiếu nại đã được thụ lý giải quyết kể từ {{ $appointment_time->format('m:h') . ' ngày ' . $appointment_time->format(' d/m/Y') }}</p>
                                            <p>Vậy thông báo để Ông(Bà) {{$complain->user->name}} được biết.</p>
                                            <p style="text-align: right; font-weight: bold">Người đứng đầu cơ quan, tổ chức, đơn vị</p>
                                            <p style="text-align: right; margin-right: 40px"><i>(Ký, ghi rõ họ tên và đóng dấu)</i></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
