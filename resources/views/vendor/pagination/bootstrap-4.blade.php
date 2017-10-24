@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo; 上一页</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; 上一页</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link page-ling">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link page-ling">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link page-ling" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo; 下一页</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo; 下一页</span></li>
        @endif
    </ul>
    <ul class="pagination" style="float: right">
        <li class="page-item disabled"> <span class="page-link">当前：{{ $paginator->currentPage() }} 页</span></li>
    </ul>
@endif
