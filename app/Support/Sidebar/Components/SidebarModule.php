<?php

namespace App\Support\Sidebar\Components;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class SidebarModule implements Arrayable
{
    protected array $features = [];

    public function __construct(protected string $name, protected string $icon, protected bool $showHeader)
    {
    }

    public function push(string|array $feature): static
    {
        $this->features = array_merge($this->features, Arr::wrap($feature));

        return $this;
    }

    public function toArray()
    {
        return [
            'name'  => $this->name,
            'icon'  => $this->icon,
            'showHeader'  => $this->showHeader,
            'items' => array_map(function ($instance) {
                throw_if(! ($instance instanceof SidebarLink) && ! ($instance instanceof SidebarMenu));

                return $instance->toArray();
            }, $this->features),
        ];
    }
}
