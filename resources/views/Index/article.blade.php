@extends('base.base')

@section('keywords')
    {{ $data->f('keyWord') }}
@endsection

@section('des')
    {{ filterTitle($data->f('article_id'),$data->f('title')) }}
@endsection

@section('title')
    {{ filterTitle($data->f('article_id'),$data->f('title')) }}
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
        <h2 class="blog-post-title">{{ filterTitle($data->f('article_id'),$data->f('title')) }}</h2>
        <p class="blog-post-meta"> {{ date('Y-m-d H:i:s', $data->f('create_date')) }} </p>
        <div style="position: relative">
            <div style="display: block;">
                {!! filterArticle($data->f('article_id'), $data->f('article')) !!}
            </div>
            <p class="blog-post-meta">57早知道 ---------------------------------- </p>
        </div>
        <img src="{{ asset('img/57zzd_guide_guanzhu.png') }}">
    </div><!-- /.blog-post -->


    @if(count($movie_list) >= 2 )
        <div style="margin-top: 50px;">
            <div style="background-color: #b0b0b0; padding: 5px; margin-bottom: 10px">
                <h3>57-电影</h3>
            </div>
            <div class="slick ling-slick">
                @foreach ($movie_list as $value)
                    <div class="col-sm-4" style="padding: 0">
                        <a href="{{ $value->id }}">
                            <div class="image" style="background-image: url({{ movie_img_filter($value->img) }});background-size:100% 99.9%;">
                            </div>
                        </a>
                        <div style="position: absolute;bottom: 0; background-color: rgba(0,0,0,0.53);">
                            <p style="font-size: 12px; margin: 0;color: rgba(255,255,255,0.76);display: block;overflow: hidden;">
                                {{ $value->title }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div style="margin-top: 30px; background-color: #b0b0b0; padding: 20px">
        <h3>阅读推荐</h3>
    </div>
    <div class="ling-list-box">
        <ul class="ling-list">
            @foreach($recommendation as $l)
                <li>
                    @if($l->f('title_image'))
                        <div class="ling-img-box">
                            <a href="/article/{{ $l->f('article_id') }}" class="thumbnail">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($l->f('title_image')) }}" style="background:#ccc  no-repeat center center">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3><a class="btn-link" href="/article/{{ $l->f('article_id') }}">{{ filterTitle($l->f('article_id'),$l->f('title')) }}</a></h3>
                        <p class="abstract">{{ filterAbstract($l->f('article_id'),$l->f('abstract')) }}</p>
                        <div class="tips">
                            {{--<a style="float:left; margin-right:30px">作者</a>--}}
                            {{--<a style="float:left; margin-right:30px">{{ $l->name }}</a>--}}
                            {{--<p style="float:left; margin-right:20px; color: black;">{{ $l->name }}</p>--}}
                            <p style="float: left">{{ format_time($l->f('create_date')) }}</p>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div> <!-- ling-list-box -->

@endsection

@section('js')

@endsection