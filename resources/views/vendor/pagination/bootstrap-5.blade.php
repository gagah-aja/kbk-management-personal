{{-- File: resources/views/vendor/pagination/bootstrap-5.blade.php --}}

@if ($paginator->hasPages())
    <nav class="pagination-nav">
        <ul class="pagination mb-0">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="bi bi-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
/* Custom Pagination Styles */
.pagination-nav {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination {
    display: flex;
    gap: 0.35rem;
    list-style: none;
    padding: 0;
    margin: 0;
}

.page-item {
    display: inline-block;
}

.page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0.5rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #fff;
    color: #475569;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}

.page-link:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #1e293b;
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.page-link:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
}

.page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    color: #fff;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    cursor: default;
    pointer-events: none;
}

.page-item.disabled .page-link {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #cbd5e1;
    cursor: not-allowed;
    pointer-events: none;
}

/* Previous & Next Icons */
.page-link i {
    font-size: 1rem;
}

/* Responsive */
@media (max-width: 576px) {
    .pagination {
        gap: 0.25rem;
    }
    
    .page-link {
        min-width: 35px;
        height: 35px;
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
    }
    
    /* Hide middle page numbers on mobile, keep first, last, and current */
    .page-item:not(.active):not(:first-child):not(:last-child):not(:nth-child(2)):not(:nth-last-child(2)) {
        display: none;
    }
}
</style>