<li class=" @if($item->hasItems()) treeview @endif clearfix">
    <a href="{{ $item->getUrl() }}" @if(count($appends) > 0)class="hasAppend"@endif>
        <i class="@if($item->getIcon()) {{ $item->getIcon() }} @else fa fa-angle-double-right @endif"></i>
        <span>{{ $item->getName() }}</span>

        @foreach($badges as $badge)
            {!! $badge !!}
        @endforeach

        {{-- TODO: add toggleIcon getter --}}
        @if($item->hasItems())<i class="@if($item->getIcon()) {{ $item->getIcon() }} @else fa fa-angle-left @endif pull-right"></i>@endif
    </a>

    @foreach($appends as $append)
        {!! $append !!}
    @endforeach

    @if(count($items) > 0)
        <ul class="treeview-menu">
            @foreach($items as $item)
                {!! $item !!}
            @endforeach
        </ul>
    @endif
</li>
