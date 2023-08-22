<?php

namespace App\Datatables\Dashboard\Core;

use App\Models\ContactUs;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class ContactsDatatable extends BaseDatatable
{
    protected ?string $actionable = 'show';

    public function query(): Builder
    {
        return ContactUs::query();
    }

    protected function getCustomColumns(): array
    {
        return [
            'name'       => function ($model) {
                $title = $model->name;

                return view('components.datatable.title', compact('title'));
            },
            'email' => function ($model) {
                $title = $model->name;

                return view('components.datatable.title', compact('title'));
            },
            'phone' => function ($model) {
                $title = $model->phone;

                return view('components.datatable.title', compact('title'));
            },

        ];
    }

    protected function getColumns(): array
    {
        return [

            Column::computed('name')->title(t_('Name')),
            Column::computed('email')->title(t_('Email')),
            Column::computed('phone')->title(t_('Phone')),

        ];
    }
}
