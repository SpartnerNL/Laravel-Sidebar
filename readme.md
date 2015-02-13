# Laravel Sidebar

#### Adding a menu

```php
$builder = app('Maatwebsite\Sidebar\SidebarManager');

$builder->group('app', function ($group)
{
    $group->addItem('dashboard', function($item)
    {
        // Route method automatically transforms it into a route
        $item->route('acp.dashboard');

        // If you want to call route() yourself to pass optional parameters
        $item->route = route('acp.dashboard');
    });
}
```

#### Groups

It's possible to group the menu items. A little header will be rendered to separate the different menu items.

#### Adding items

The first parameter of `$group->addItem()` is the name. The name field will automatically be translated through the `menu` translation file. (e.g. `menu.dashboard`). If the translation does not exists, the given name will be displayed.

The second parameter is optionally a callback. Alternativly you can chain the methods.

You can change the `route`, `name` and `icon`. If you route given it will automatically be translated to `acp.{$name}.index`.

#### Item children

We can go a level deeper with the menu items by calling `$item->addItem()`. This will automatically nest them. You can add the same values to them as their parent item (including appends and badges).

#### Group less

To disable rendering the group headings, you can easily use `$builder->groupLess()`. Group headings will now be ignored.

### Appends

To append a quick link, you can use `$item->append()`. You can either pass the route or pass a callback:

```php
// This will append a plus sign
$item->append('acp.pages.create');

// Chain methods
$item->append('acp.pages.custom')->icon('fa fa-pencil');

$item->append(function($append)
{
    $append->route('acp.pages.custom');
    $append->icon = 'fa fa-pencil';
});
```

You can add as many appends as you want!

#### Badges

To append a badge you can use `$item->badge()` You can either pass the value and color or pass a callback:

```php
// This will add a quick badge with green color and the word new
$item->badge('new', 'badge-success');

// Chain methods
$item->badge('new)->color('badge-success');

// Inside the closure you can make use of dependency injection
$item->badge(function($append, PageRepository $repo)
{
    // Display a dynamic value
    $append->value = $repo->getCount();
});
```

#### Authorization

By default all groups, items, appends and badges are public for all users. You can use `->authorized(false)` on all these objects to disable them.
