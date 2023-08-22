<?php

namespace Database\Seeders;

use App\Enums\Core\RolesEnum;
use App\Models\User;
use Auth;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Artisan::call('permission:cache-reset');
        $this->setupPermissions();
        //
        $this->setupRoles();
        $this->setupUsers();
    }

    private function setupUsers()
    {
        Auth::shouldUse('dashboard');
        tap(User::updateOrCreate(['email' => 'admin@admin.com'], [
            'name'     => 'Super Admin',
            'email'    => 'admin@admin.com',
            'active'   => true,
            'password' => '123456',
        ]))->assignRole([
            RolesEnum::super()->value,
            RolesEnum::admin()->value,
        ]);
        echo 'Admins Created Successfully'.PHP_EOL;
    }

    private function setupRoles()
    {
        Role::query()->delete();
        $roles = collect(RolesEnum::toArray())
            ->transform(fn ($i) => ['name' => $i, 'guard_name' => 'dashboard'])
            ->toArray();

        Role::insert($roles);

        Role::findByName('super', 'dashboard')
            ->permissions()->sync(Permission::where('guard_name', 'dashboard')->pluck('id'));

        echo 'Roles Created Successfully'.PHP_EOL;
    }

    private function setupPermissions()
    {
        Permission::query()->delete();
        $permissions = collect([
            'administration',
            'view_admins',
            'view_roles',
            'view_pages',
            'view_setting',
        ]);
        Permission::insert($permissions->transform(fn ($i) => ['name' => $i, 'guard_name' => 'dashboard'])
                                       ->toArray());
        echo 'Permissions Created Successfully'.PHP_EOL;

        return $permissions;
    }
}
