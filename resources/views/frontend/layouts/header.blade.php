<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" lang="{{ LaravelLocalization::getCurrentLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ trans("web.zahra") }}</title>

    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=662fbda2a67ccd0019e8e822&product=inline-share-buttons&source=platform" async="async"></script>

    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="@if(session()->has('share_title')) {{ session()->get('share_title') }} @else {{ trans("web.zahra") }} @endif"/>
    <meta property="og:description"
          content="@if(session()->has('share_description')) {{ session()->get('share_description') }} @endif"/>
    <meta property="og:image" content="@if(session()->has('share_image')) {{ session()->get('share_image') }} @endif"/>

    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/logo.png') }}">
    <!-- bootstrap 5 id english -->
    @if(LaravelLocalization::getCurrentLocale() == 'en')
        <link href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
              crossorigin="anonymous">
    @endif
    <!-- bootstrap 5 if arabic -->
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
              integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N"
              crossorigin="anonymous">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://fastly.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    @yield('style')
    <!-- to load google font faster -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700;800;900;1000&display=swap"
          rel="stylesheet">
    <!-- font type if arabic -->
    @if(LaravelLocalization::getCurrentLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
              rel="stylesheet">
    @endif
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.min.css') }}">

    @livewireStyles
</head>
<body class="@if(LaravelLocalization::getCurrentLocale() == 'ar') rtl @endif">