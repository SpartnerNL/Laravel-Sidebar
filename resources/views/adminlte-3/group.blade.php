@if($group->shouldShowHeading())
    <li class="nav-header">{{ $group->getName() }}</li>
@endif

@foreach($items as $item)
    {!! $item !!}
@endforeach
