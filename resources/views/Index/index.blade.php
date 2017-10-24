@extends('base.base')
@section('title')
    @parent
    @if($category && $category != 'new')
        - {{ $category_list[$category] }}
    @else
        - 首页
    @endif
@endsection

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-ling">

        @if($category && $category != 'new')
            <li><a href="/">首页</a></li>
            <li class="active">{{ $category_list[$category]['name'] }}</li>
        @else
            <li class="active">首页</li>
        @endif
    </ol>
@endsection

@section('content')
    <div class="ling-list-box">
        <ul class="ling-list">
            @foreach($list as $l)
                <li>
                    @if($l->f('title_image'))
                        <div class="ling-img-box">
                            <a href="/article/{{ $l->f('article_id') }}" tabindex="-1">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($l->f('title_image')) }}" style="background:#ccc  no-repeat center center" class="img-rounded">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3><a class="btn-link" href="/article/{{ $l->f('article_id') }}" tabindex="-1">{{ filterTitle($l->f('article_id'),$l->f('title')) }}</a></h3>
                        <p class="abstract">{{ filterAbstract($l->id,$l->f('abstract')) }}</p>
                        <div class="tips">
                            <p style="float:left; margin-right:10px">
                                {{--<a >作者</a>--}}
                            </p>
                            {{--<a style="float:left; margin-right:30px">{{ $l->name }}</a>--}}
                            <p style="float:left; margin-right:10px; color: black;">{{ $l->f('category') }}</p>
                            <p style="float: left; margin-right:10px;">{{ format_time($l->f("create_date")) }}</p>
                            {{--<p style="float: left;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{ $l->click_amount }} </p>--}}
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div> <!-- ling-list-box -->
    <div>
        {{ $paginator->links('vendor/pagination/bootstrap-4') }}
    </div>
@endsection

@section('js')

@endsection