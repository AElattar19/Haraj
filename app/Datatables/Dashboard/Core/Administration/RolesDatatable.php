<?php

namespace App\Datatables\Dashboard\Core\Administration;

use App\Enums\Core\RolesEnum;
use App\Support\Datatables\BaseDatatable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Column;

class RolesDatatable extends BaseDatatable
{
    protected ?string $actionable = 'view|edit|delete';

    public function query(): Builder
    {
        return Role::whereGuardName('dashboard')
                   ->whereNotIn('name', RolesEnum::toArray())
                   ->withCount('permissions');
    }

    protected function getColumns(): array
    {
        return array_merge([
            Column::make('name')->title(t_('Name')),
            Column::make('permissions_count')->title(t_('Permissions Count'))
                  ->searchable(false)
                  ->orderable(false),
        ], parent::getColumns());
    }
}
