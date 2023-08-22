<?php

namespace App\Support\Sidebar\Components;

use Illuminate\Contracts\Support\Arrayable;

class SidebarLink implements Arrayable
{
    public function __construct(
        protected string $name,
        protected string $url,
        protected string $icon = '',
        protected string $iconType = '',
        protected string $permission = '',
    ) {
    }

    public static function to(
        string $name,
        string $url,
        string $icon = '',
        string $iconType = '',
        string $permission = '',

    ): static {
        return new static($name, $url, $icon, $iconType, $permission);
    }

    public function permission(string $permission): static
    {
        $this->permission = $permission;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name'       => $this->name,
            'icon'       => $this->icon,
            'icon_type'  => $this->iconType,
            'permission' => $this->permission,
            'url'        => $this->url,
        ];
    }
}
