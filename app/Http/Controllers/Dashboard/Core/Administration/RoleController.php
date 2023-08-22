<?php

namespace App\Http\Controllers\Dashboard\Core\Administration;

use App\Datatables\Dashboard\Core\Administration\RolesDatatable;
use App\Http\Controllers\Controller;
use App\Support\Crud\WithCrud;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    use WithCrud;

    protected string $path = 'dashboard.core.administration.roles';

    protected string $model = Role::class;

    protected string $datatable = RolesDatatable::class;

    protected function formData(?Model $model = null): array
    {
        return [
            'permissions' => toMap(Permission::whereGuardName('dashboard')->get(['id', 'name'])),
        ];
    }

    protected function rules()
    {
        return [
            'name'        => 'required|string|max:191|not_in:admin,user,super|unique:roles,name,'.request()->route('role'),
            'permissions' => 'required|array',
        ];
    }

    protected function storeAction(array $validated)
    {
        $permissions = Arr::pull($validated, 'permissions');
        $validated['guard_name'] = 'dashboard';
        $role = Role::create($validated);
        $role->syncPermissions($permissions);
    }

    protected function updateAction(array $validated, Model $model)
    {
        $model->syncPermissions(Arr::pull($validated, 'permissions', []));
        $model->update($validated);
    }
}
