<?php

namespace App\Datatables\Dashboard\User;

use App\Models\User;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class UserDatatable extends BaseDatatable
{
    public function query(): Builder
    {
        return User::query()->withoutGlobalScopes()->whereKeyNot(1)->whereDoesntHave('roles')->latest();
    }

    protected function getCustomColumns(): array
    {
        return [

            'active' => function ($model) {

                return view('components.datatable.active', ['active' => $model->active]);
            },
        ];
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')->title(t_('Name')),
            Column::make('email')->title(t_('Email')),
            Column::computed('active')->title(t_('Status')),
        ];
    }
}
