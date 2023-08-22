<?php

namespace App\Datatables\Dashboard\Core\Administration;

use App\Models\User;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Column;

class AdminsDatatable extends BaseDatatable
{
    public function query(): Builder
    {

        return User::whereKeyNot(1)->role('admin')->latest()->withoutGlobalScopes();
    }

    protected function getColumns(): array
    {
        return [
            Column::make('name')->title(t_('Name')),
            Column::make('email')->title(t_('Email')),
        ];
    }
}
