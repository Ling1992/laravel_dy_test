@if(count($movie_list) >= 2 )
    <div class="sidebar-module sidebar-module-inset">
        <h4>57-电影</h4>
        <div class="slick">
            @foreach ($movie_list as $value)
                <div class="col-sm-4" style="padding: 0">
                    <div class="image">
                        <a href="{{ $value->id }}">
                            <img src="{{ movie_img_filter($value->img) }}" style="width: 100%; height: 160px"/>
                        </a>
                    </div>
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
<div class="sidebar-module sidebar-module-inset" style="margin-top: 10px">
    <img src="{{ asset('img/57zzd_guide_guanzhu.png') }}" width="100%">
</div>
<div class="sidebar-module sidebar-module-inset">
    <h4>阅读推荐</h4>
    <ol class="list-unstyled">
        @foreach($recommendation as $r)
            <li class="row" style="margin: 0;">
                @if($r->f('title_image'))
                    <div class="col-sm-4" style="padding: 0;margin: 0">
                        <a target="_blank" href="/article/{{ $r->f('article_id') }}" class="thumbnail">
                            <img src="{{ asset('img/blank.gif') }}" data-echo="{{ env('img_src_pre','').urlFilter($r->f('title_image')) }}">
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <span><a target="_blank" href="/article/{{ $r->f('article_id') }}">{{ filterTitle($r->f('article_id'),$r->f('title')) }}</a></span>
                        <div class="">
                            <p>{{ format_time($r->f('create_date')) }}</p>
                        </div>
                    </div>
                @else
                    <div class="row" style="margin: 0;">
                        <span><a target="_blank" href="/article/{{ $r->f('article_id') }}">{{ filterTitle($r->f('article_id'),$r->f('title')) }}</a></span>
                        <div class="">
                            <p>{{ format_time($r->f('create_date')) }}</p>
                        </div>
                    </div>
                @endif
            </li>
        @endforeach
    </ol>
</div>
