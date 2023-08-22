<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Datatables\Dashboard\User\UserDatatable;
use App\Enums\Core\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\User\UsersRequest;
use App\Models\User;
use App\Support\Crud\WithDatatable;
use App\Support\Crud\WithDestroy;
use App\Support\Crud\WithForm;
use App\Support\Crud\WithStore;
use App\Support\Crud\WithUpdate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use WithDatatable, WithForm, WithStore, WithUpdate, WithDestroy;

    protected string $path = 'dashboard.user.users';

    protected string $datatable = UserDatatable::class;

    protected string $model = User::class;

    protected function storeAction(array $validated)
    {
        $roles = Arr::pull($validated, 'roles', []);
        $model = $this->queryBuilder()->create($validated);

        if(isset($validated['avatar']))
        {
            $model->clearMediaCollection('user');
            $model->addMedia(Arr::pull($validated, 'avatar'))->toMediaCollection('avatar');
        }
    }

    protected function updateAction(array $validated, Model $model)
    {
        $roles = Arr::pull($validated, 'roles', []);
        $model->update($validated);

        if(isset($validated['avatar']))
        {
            $model->clearMediaCollection('user');
            $model->addMedia(Arr::pull($validated, 'avatar'))->toMediaCollection('avatar');
        }

    }

    protected function validationAction(): array
    {
        return app(UsersRequest::class)->validated();
    }

    protected function formData(?Model $model = null): array
    {
        return [
            'phone' => $model?->info?->phone,
            'selected' => $model?->getRoleNames(),
            'roles'    => toMap(Role::where('guard_name', 'web')
                ->whereNotIn('name', RolesEnum::toArray())
                ->get(['id', 'name']), 'name'),
            'avatar' => $model?->getFirstMediaUrl('avatar'),

        ];
    }
}
