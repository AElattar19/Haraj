<?php

namespace App\Support\Sidebar\Components;

use Illuminate\Contracts\Support\Arrayable;

class SidebarGenerator implements Arrayable
{
    private array $items = [];

    private array $modules = [];

    public function addModule(string $name, string $icon, bool $showHeader = true): SidebarModule
    {
        return $this->modules[$name] = new SidebarModule($name, $icon, $showHeader);
    }

    public static function create(): static
    {
        return new static();
    }

    public function toArray(): array
    {
        return array_map(fn (SidebarModule $i) => $i->toArray(), $this->modules);
    }
}
