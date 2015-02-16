@if($group->enabled)
    <li class="menu-title">{{ $group->name }}</li>
@endif

@foreach($group->getItems() as $item)
    {!! $item->render() !!}
@endforeach
