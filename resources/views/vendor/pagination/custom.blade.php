@if ($paginator->hasPages())
    <div class="basic-pagination-wrap">
        <div class="row">
            <div class="col-xl-6">
                <div class="basic-pagination mb-0">
                    <nav>
                        <ul>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                                    <span><i class="fa-regular fa-angle-left"></i></span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                                        <i class="fa-regular fa-angle-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        @if ($page == $paginator->currentPage())
                                            <li><span class="current">{{ $page }}</span></li>
                                        @else
                                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <li>
                                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                                        <i class="fa-regular fa-angle-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                                    <span><i class="fa-regular fa-angle-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif
