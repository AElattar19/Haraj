<?php

namespace App\Support\Sidebar\Components;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class SidebarMenu implements Arrayable
{
    public function __construct(
        protected string $name,
        protected string $icon = '',
        protected string $iconType = '',
        protected string $permission = '',
        protected array $items = [],
    ) {
    }

    public static function create(string $name, string $icon = '', string $iconType = '', string $permission = '')
    {
        return new static($name, $icon, $iconType, $permission);
    }

    public function permission(string $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    public function push(array|SidebarLink|SidebarMenu $items): static
    {
        $this->items = Arr::wrap($items);

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'permission' => $this->permission,
            'icon'       => $this->icon,
            'icon_type'  => $this->iconType,
            'items'      => array_map(function ($instance) {
                throw_if(! ($instance instanceof SidebarLink));

                return $instance->toArray();
            }, $this->items),
        ];
    }
}
