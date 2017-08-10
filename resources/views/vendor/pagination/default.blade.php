@if ($paginator->hasPages())
    <div class="row">
        <div class="col-lg-8">
            <div class="btn-group">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <button type="button" class="btn btn-white disabled"><i class="fa fa-chevron-left"></i></button>
                @else
                    <a class="btn btn-white" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-chevron-left"></i></a>
                @endif
                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <button class="btn btn-white disabled">{{ $element }}</button>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button class="btn btn-white active">{{ $page }}</button>
                            @else
                                <a class="btn btn-white" href="{{ $url }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a class="btn btn-white" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-chevron-right"></i></a>
                @else
                    <button type="button" class="btn btn-white disabled"><i class="fa fa-chevron-right"></i> </button>
                @endif
            </div>
        </div>
        <div class="col-lg-4">
            <p>Mostrando {{ $paginator->perPage() }} resultados por pagina de {{ $paginator->total() }} resultados</p>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-lg-12">
            <p>Mostrando todos los resultados</p>
        </div>
    </div>
@endif
