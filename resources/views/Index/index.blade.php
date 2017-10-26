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
                    @if($l->image_url)
                        <div class="ling-img-box">
                            <a href="/Content/{{ $l->id }}" tabindex="-1">
                                <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($l->image_url) }}" style="background:#ccc  no-repeat center center" class="img-rounded">
                            </a>
                        </div>
                    @endif
                    <div class="ling-txt-box">
                        <h3><a class="btn-link" href="/article/{{ $l->dy_id }}" tabindex="-1">{{ $l->title }}</a></h3>
                        <p class="abstract"></p>
                        <div class="tips">
                            <p style="float: left; margin-right:10px;">{{ date('Y-m-d', $l->update_time) }}</p>
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