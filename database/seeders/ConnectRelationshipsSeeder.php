<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Roles.
         */
        $roleSuperAdmin = config('roles.models.role')::where('slug', '=', 'superadmin')->first();
        $roleAdmin = config('roles.models.role')::where('slug', '=', 'admin')->first();

        foreach ($permissions as $permission) {
            if ($permission->model != 'Role') {
                $roleAdmin->attachPermission($permission);
            }
            $roleSuperAdmin->attachPermission($permission);
        }
    }
}
