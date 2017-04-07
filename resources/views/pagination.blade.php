@if ($paginator->hasPages())
     <ul class="pagination pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->url(1) }}" >&laquo;</a></li>
        @endif
        @if ($paginator->currentPage()==1 || $paginator->currentPage()==$paginator->lastPage())
            @php
                $i = 2
            @endphp
        @else
            @php
                $i = 1
            @endphp
        @endif
        @for ($x=max($paginator->currentPage()-$i, 1); $x<=max(1, min($paginator->lastPage(),$paginator->currentPage()+$i)); $x++)
            <li><a href="{{ $paginator->url($x) }}">{{ $x }}</a></li>
        @endfor
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}">&raquo;</a></li>
        @else
            <li class="disabled"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
