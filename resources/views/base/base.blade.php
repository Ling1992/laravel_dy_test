<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    {{--<meta name="referrer" content="never">--}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{--<!-- 站长 -->--}}
    {{--<meta name="baidu-site-verification" content="xXN4NvYoFW" />--}}
    {{--<!-- 360 -->--}}
    {{--<meta name="360-site-verification" content="4f775ffdfd2567e54ad13073cb07369e" />--}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="keywords" content="@section('keywords')57早知道, 早知道, 早知道网, 57新闻, 早知道新闻, 57早知道官网@show">
    <meta name="description" content="@section('des')57早知道, 致力于分享各种类型的好文章给大家@show">

    <title>
        @section('title')
            57早知道
        @show
    </title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{ asset('bootstrap/assets/css/ie10-viewport-bug-workaround.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('bootstrap/base.css') }}" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="{{ asset('bootstrap/assets/js/ie8-responsive-file-warning.js') }}"></script><![endif]-->
    <script src="{{ asset('bootstrap/assets/js/ie-emulation-modes-warning.js') }}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css"/>

    <style type="text/css">
        a:link {
            color: #0000cb;
            text-decoration: none;
        }
        a:visited {
            color: #4b1689;
        }
        a:hover {
            color: #999999;
        }
    </style>
</head>
<body>
@include('base.menu_navbar')
<div class="container ling-container ling-container-main">

    <div class="row" style="margin: 0;">
        @section('breadcrumb')
        @show
        <div class="col-sm-8 ling-main">
            @section('content')
            @show
        </div> <!-- article_list -main -->
        <div class="col-sm-4 index-sidebar">
            @include('base.about_siderbar')
        </div><!-- /.blog-sidebar -->
    </div><!-- /.row -->

</div><!-- /.container -->

<div class="container">
    @include('base.footer')
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="http://lib.sinaapp.com/js/jquery/1.12.4/jquery-1.12.4.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery.min.js') }}"><\/script>')</script>
<script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="{{ asset('bootstrap/assets/js/ie10-viewport-bug-workaround.js') }}"></script>
<script src="{{ asset('js/echo.min.js') }}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.js"></script>

<script>
    echo.init({
        offset: 0,
        throttle: 2
    });
</script>

<script type="text/javascript">
    $(function(){
        $('.slick').slick({
            dots: false,
            lazyLoad: 'ondemand',
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows:false
        });
    });
</script>

{{--<!-- 百度统计 -->--}}
{{--<script>--}}
    {{--var _hmt = _hmt || [];--}}
    {{--(function() {--}}
        {{--var hm = document.createElement("script");--}}
        {{--hm.src = "https://hm.baidu.com/hm.js?94e8b3a588e30f9d6ae660cdc60731c3";--}}
        {{--var s = document.getElementsByTagName("script")[0];--}}
        {{--s.parentNode.insertBefore(hm, s);--}}
    {{--})();--}}
{{--</script>--}}

{{--<!-- 360 主动收录 -->--}}
{{--<script>(function(){--}}
        {{--var src = (document.location.protocol == "http:") ? "http://js.passport.qihucdn.com/11.0.1.js?3c0038ae1f5880a0a591b308f53843d6":"https://jspassport.ssl.qhimg.com/11.0.1.js?3c0038ae1f5880a0a591b308f53843d6";--}}
        {{--document.write('<script src="' + src + '" id="sozz"><\/script>');--}}
    {{--})();--}}
{{--</script>--}}

@section('js')
@show
</body>
</html>
