<?php

namespace App\Datatables\Dashboard\Core;

use App\Models\Page;
use App\Support\Datatables\BaseDatatable;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class PagesDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit';

    public function query(): Builder
    {
        return Page::query();
    }

    protected function getFilters(): array
    {
        return [
            'title.'.app()->getLocale() => CustomFilters::translated('title'),
        ];
    }

    protected function getColumns(): array
    {
        return [
            $this->column('title.'.app()->getLocale(), t_('Title')),
        ];
    }
}
