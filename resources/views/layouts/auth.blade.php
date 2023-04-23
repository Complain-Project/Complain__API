<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- CSRF Token --}}

    <title>Cổng Thông Tin Tiếp Nhận Khiếu Nại</title>

    {{-- Start Styles--}}
    {{--    <link rel="shortcut icon" href="/images/favicon.png">--}}
    <link rel="stylesheet" href="/bootstrap-5.2.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="{{ mix('/css/_auth.css') }}">

    @yield('styles')
    {{-- End Styles--}}

    {{-- Start fontawesome--}}
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    {{-- End fontawesome--}}

    {{-- Start Scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript"
            src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="/bootstrap-5.2.2-dist/js/bootstrap.min.js"></script>
    <script src="/fontawesome/js/all.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
    </script>
    {{-- End Scripts --}}
</head>
<body>
<div id="app">
    {{--  Start main--}}
    <div class="container-fluid">
        <div class="d-flex justify-content-center pt-5 pb-5">
            <div class="col text-center flex-column">
                <a href="{{route('home')}}">
                    <img src="/images/logo.svg" alt="Smiley face" height="80" width="210">
                </a>
            </div>
        </div>

        <main id="main">
            @yield('content')
        </main>
    </div>
    {{--  End main--}}
</div>

{{-- Start Scripts --}}
<script src="{{ mix('/js/_auth.js') }}"></script>
{{--End Scripts --}}

@if(Session::has('success'))
    <script>
        toastr.success("{!! Session::get('success') !!}");
    </script>
@elseif(Session::has('error'))
    <script>
        toastr.error("{!! Session::get('error') !!}");
    </script>
@elseif(Session::has('warning'))
    <script>
        toastr.error("{!! Session::get('warning') !!}");
    </script>
@endif

<script>
    window.addEventListener('alert', event => {
        toastr[event.detail.type](event.detail.message,
            event.detail.title ?? ''), toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true,
        }
    });
</script>

</body>
</html>
