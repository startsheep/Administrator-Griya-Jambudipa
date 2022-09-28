<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    use DisableForeignKey, TruncateTable;

    public function run()
    {
        $roles = ['Admin', 'Staff'];

        $access[1]['Dashboard'] = ['view'];
        $access[1]['CompanyProfile'] = ['view', 'edit', 'update'];
        $access[1]['Kavling'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'export'];
        $access[1]['TypeHouse'] = ['view', 'create', 'update', 'edit', 'delete', 'filter'];
        $access[1]['Employee'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'update-status', 'detail'];
        $access[1]['Position'] = ['view', 'create', 'update', 'edit', 'delete', 'filter'];
        $access[1]['Customer'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail'];
        $access[1]['Contractor'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status'];
        $access[1]['User'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status', 'reset-password', 'activity-log'];
        $access[1]['Transaction'] = ['view', 'filter', 'detail', 'export'];
        $access[1]['Payment'] = ['view', 'filter', 'detail', 'export', 'pay'];
        $access[1]['WholeJobHome'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];
        $access[1]['WholeJobOther'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];
        $access[1]['PriceBuilding'] = ['view', 'filter', 'export', 'create-detail', 'update-detail', 'edit-detail', 'delete-detail', 'create-description', 'update-description', 'edit-description', 'delete-description', 'create-child-description', 'update-child-description', 'edit-child-description', 'delete-child-description'];
        $access[1]['PriceLand'] = ['view', 'filter', 'export', 'create-detail', 'update-detail', 'edit-detail', 'delete-detail', 'create-description', 'update-description', 'edit-description', 'delete-description', 'create-child-description', 'update-child-description', 'edit-child-description', 'delete-child-description'];

        $access[2]['Dashboard'] = ['view'];
        $access[2]['Employee'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'update-status', 'detail'];
        $access[2]['Position'] = ['view', 'create', 'update', 'edit', 'delete', 'filter'];
        $access[2]['Customer'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail'];
        $access[2]['Contractor'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status'];
        $access[2]['User'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status', 'reset-password', 'activity-log'];
        $access[2]['Transaction'] = ['view', 'filter', 'detail', 'export'];
        $access[2]['Payment'] = ['view', 'filter', 'detail', 'export', 'pay'];
        $access[2]['WholeJobHome'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];
        $access[2]['WholeJobOther'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];

        $this->disableForeignKeys();
        $this->truncate('roles');
        $this->truncate('permissions');

        $permission['Dashboard'] = ['view'];
        $permission['CompanyProfile'] = ['view', 'edit', 'update'];
        $permission['Kavling'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'export'];
        $permission['TypeHouse'] = ['view', 'create', 'update', 'edit', 'delete', 'filter'];
        $permission['Employee'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'update-status', 'detail'];
        $permission['Position'] = ['view', 'create', 'update', 'edit', 'delete', 'filter'];
        $permission['Customer'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail'];
        $permission['Contractor'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status'];
        $permission['User'] = ['view', 'create', 'update', 'edit', 'delete', 'filter', 'detail', 'update-status', 'reset-password', 'activity-log'];
        $permission['Transaction'] = ['view', 'filter', 'detail', 'export'];
        $permission['Payment'] = ['view', 'filter', 'detail', 'export', 'pay'];
        $permission['WholeJobHome'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];
        $permission['WholeJobOther'] = ['view', 'filter', 'recapitulation', 'export', 'create', 'update', 'edit', 'delete'];
        $permission['PriceBuilding'] = ['view', 'filter', 'export', 'create-detail', 'update-detail', 'edit-detail', 'delete-detail', 'create-description', 'update-description', 'edit-description', 'delete-description', 'create-child-description', 'update-child-description', 'edit-child-description', 'delete-child-description'];
        $permission['PriceLand'] = ['view', 'filter', 'export', 'create-detail', 'update-detail', 'edit-detail', 'delete-detail', 'create-description', 'update-description', 'edit-description', 'delete-description', 'create-child-description', 'update-child-description', 'edit-child-description', 'delete-child-description'];

        foreach ($permission as $key => $item) {
            foreach ($item as $permission) {
                DB::table('permissions')->insert(['name' => strtolower($key) . '.' . $permission, 'guard_name' => 'api']);
            }
        }

        foreach ($roles as $role) {
            $role = Role::create([
                'name' => $role,
                'guard_name' => 'api'
            ]);
            if (isset($access[$role->id])) {

                $permissionToRole = [];

                foreach ($access[$role->id] as $keys => $perm) {
                    foreach ($perm as $accessPermission) {
                        $permissionToRole[] = strtolower($keys) . '.' . $accessPermission;
                    }
                }
                $perms = Permission::whereIn('name', $permissionToRole)->pluck('name');
                $role->syncPermissions($perms);
            }
        }

        $user = User::where('id', 1)->first();
        $user->role_id = 1;
        $user->save();

        if ($user->role_id == 1) {
            $user->assignRole(Role::where('name', 'Admin')->first());
        }


        $this->enableForeignKeys();
    }
}
