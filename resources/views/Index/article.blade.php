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
    </div><!-- /.blog-post -->

@endsection

@section('js')

@endsection