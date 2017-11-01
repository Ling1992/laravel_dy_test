@extends('base.base')

@section('keywords')
    {{ $data->f('keyWord') }}
@endsection

@section('des')
    {{ filterTitle($data->f('dy_id'),$data->f('title')) }}
@endsection

@section('title')
    {{ filterTitle($data->f('dy_id'),$data->f('title')) }}
    -
    @parent
@endsection


@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-ling">
        <li><a href="/">首页</a></li>
        @if($category && $category != 'new')
            <li><a href="/category/{{ $category }}">{{ $category_list[$category]['name'] }}</a></li>
        @endif
        <li class="active">正文</li>
    </ol>
@endsection


@section('content')

    <div class="blog-post" style="position: relative">
        <h2 class="blog-post-title">{{ $data->title }}</h2>
        <p class="blog-post-meta"> {{ date('Y-m-d', $data->update_time) }} </p>
        <div style="position: relative">
            <div style="display: block;">
                {!! $data->content !!}
            </div>
            <p class="blog-post-meta">57大收录 ---------------------------------- </p>
        </div>
        <div>
            <p style="text-align: center;">
                <span style="color: rgb(84, 141, 212);">资源找不到？ 资源链接失效？ </span>
            </p>
            <p style="text-align: center;">
                <span style="color: rgb(84, 141, 212);">那就加入我们 57大收录 交流群吧 ！！</span>
            </p>
            <p style="text-align: center;">
                <span style="color: rgb(84, 141, 212);">资源互享 当然你们还能结识志同道合的伙伴 哦！！</span>
            </p>
            <p style="text-align: center;">
                <img src="{{ asset('img/qun.JPG') }}" title="qun.jpg" alt="qun.JPG" style="width: 60%"/>
            </p>
        </div>
        <div>
            <p style="text-align: center;">
                <span style="color: rgb(84, 141, 212);">扫描二维码关注 57大收录，做老司机，防迷路， </span>
            </p>
            <p style="text-align: center;">
                <span style="color: rgb(84, 141, 212);">查看更多电影信息，回复片名，火速获取</span>
            </p>
            <p style="text-align: center;">
                <img src="{{ asset('img/qrcode_for_gh_3f4c8072f490_1280.jpg') }}" title="qrcode_for_gh_3f4c8072f490_1280.jpg" alt="qrcode_for_gh_3f4c8072f490_1280.JPG" style="width: 60%"/>
            </p>
        </div>
    </div><!-- /.blog-post -->

@endsection

@section('js')

@endsection