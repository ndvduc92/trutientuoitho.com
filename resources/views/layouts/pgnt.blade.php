@if ($paginator->hasPages())
<div class="pagination2">
    <a href="{{ $paginator->previousPageUrl() }}">Trang đầu</a>
    @foreach ($elements as $element)
        @if (is_string($element))
        <a aria-disabled="true"><span>...</span></a>
        @endif
        @if (is_array($element))
        @foreach ($element as $page => $url)
        <a class="{{$page == $paginator->currentPage() ? 'active' : ''}}" href="{{ $url }}">{{ $page }} </a>
        @endforeach
        @endif
    @endforeach
    <a href="{{ $paginator->nextPageUrl() }}" >Trang cuối</a>

</div>
@endif