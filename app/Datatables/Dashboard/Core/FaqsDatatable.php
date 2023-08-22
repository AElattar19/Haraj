<?php

namespace App\Datatables\Dashboard\Core;

use App\Models\Faq;
use App\Support\Datatables\BaseDatatable;
use App\Support\Datatables\CustomFilters;
use Illuminate\Database\Eloquent\Builder;

class FaqsDatatable extends BaseDatatable
{
    protected ?string $actionable = 'edit|delete';

    public function query(): Builder
    {
        return Faq::query();
    }

    protected function getFilters(): array
    {
        return [
            'question.'.app()->getLocale() => CustomFilters::translated('question'),
        ];
    }

    protected function getColumns(): array
    {
        return [
            $this->column('question.'.app()->getLocale(), t_('question')),
        ];
    }
}
