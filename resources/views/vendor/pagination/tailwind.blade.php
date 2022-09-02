 <!-- <div>
    <p class="text-sm text-gray-700 leading-5">
        {!! __('Mostrando') !!}
        @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('a') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
        @else
            {{ $paginator->count() }}
        @endif
        {!! __('de') !!}
        <span class="font-medium">{{ $paginator->total() }}</span>
        {!! __('resultados') !!}
    </p>
</div> -->

@if ($paginator->hasPages())
    <nav aria-label="..." class="mb-3">
        <ul class="pagination justify-content-center">
            <li class="page-item {{$paginator->onFirstPage() ? 'disabled' : ''}}">
                <a class="page-link" href="{{$paginator->previousPageUrl()}}">Previous</a>
            </li>
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif

                <!-- Array Of Links -->
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <a class="page-link">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            <li class="page-item {{(!$paginator->hasMorePages()) ? 'disabled' : ''}}">
                <a class="page-link" href="{{$paginator->nextPageUrl()}}">Next</a>
            </li>
        </ul>
    </nav>
@endif
