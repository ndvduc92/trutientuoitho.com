@if ($paginator->hasPages())
<div class="paging">
    <ul class="page__list">
        <li class="prev"><a class="fas fa-chevron-left" href="{{ $paginator->previousPageUrl() }}"></a></li>
        @foreach ($elements as $element)
        @if (is_string($element))
        <li><a aria-disabled="true">...</a></li>
        @endif
        @if (is_array($element))
        @foreach ($element as $page => $url)
        <li><a class="{{$page == $paginator->currentPage() ? 'active' : ''}}" href="{{ $url }}">{{ $page }} </a></li>
        @endforeach
        @endif
    @endforeach
    </ul>
</div>
@endif


