<?php

namespace Database\Seeders;

use App\Enums\Permissions\AdminAccess;
use App\Enums\Permission as EnumsPermission;
use App\Enums\Permissions\PermissionGroup;
use App\Enums\Permissions\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [
            PermissionGroup::ADMIN_ACCESS->value => [
                AdminAccess::VIEW,
                AdminAccess::ADD,
                AdminAccess::EDIT,
                AdminAccess::DELETE,
            ],
            PermissionGroup::SETTINGS->value => [
                Setting::ROLES_AND_PERMISSION,
                Setting::APPLICATION_SETTING,
                Setting::SYSTEM_PREFRENCES,
            ],
        ];

        foreach ($permissions as $key => $permission) {
            if (is_array($permission)) {
                foreach ($permission as $item) {
                    if (!Permission::where('name', $item)->exists()) {
                        Permission::create([
                            'name' => $item,
                            'guard_name' => 'admin',
                            'group' => $key,
                        ]);
                    }
                }
            }
        }
    }
}