<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            //profile
            [
                'name'        => 'Can Edit Profile',
                'slug'        => 'profile.edit',
                'description' => 'Can edit profile',
                'model'       => 'Profile',
            ],
            [
                'name'        => 'Can Delete Profile',
                'slug'        => 'profile.destroy',
                'description' => 'Can delete profile',
                'model'       => 'Profile',
            ],
            //role
            [
                'name'        => 'Can View Role',
                'slug'        => 'role.show',
                'description' => 'Can view role',
                'model'       => 'Role',
            ],
            [
                'name'        => 'Can Create Role',
                'slug'        => 'role.create',
                'description' => 'Can create new role',
                'model'       => 'Role',
            ],
            [
                'name'        => 'Can Edit Role',
                'slug'        => 'role.edit',
                'description' => 'Can edit role',
                'model'       => 'Role',
            ],
            [
                'name'        => 'Can Delete Role',
                'slug'        => 'role.delete',
                'description' => 'Can delete role',
                'model'       => 'Role',
            ],
            //user
            [
                'name'        => 'Can View Users',
                'slug'        => 'users.show',
                'description' => 'Can view users',
                'model'       => 'User',
            ],
            [
                'name'        => 'Can Create Users',
                'slug'        => 'users.create',
                'description' => 'Can create new users',
                'model'       => 'User',
            ],
            [
                'name'        => 'Can Edit Users',
                'slug'        => 'users.edit',
                'description' => 'Can edit users',
                'model'       => 'User',
            ],
            [
                'name'        => 'Can Delete Users',
                'slug'        => 'users.delete',
                'description' => 'Can delete users',
                'model'       => 'User',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $Permissionitem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
            if ($newPermissionitem === null) {
                $newPermissionitem = config('roles.models.permission')::create([
                    'name'          => $Permissionitem['name'],
                    'slug'          => $Permissionitem['slug'],
                    'description'   => $Permissionitem['description'],
                    'model'         => $Permissionitem['model'],
                ]);
            }
        }
    }
}
