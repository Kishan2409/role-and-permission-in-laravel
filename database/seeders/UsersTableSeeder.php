<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $superadminRole = config('roles.models.role')::where('name', '=', 'Super Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'superadmin@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Super Admin',
                'email'    => 'superadmin@gmail.com',
                'password' => bcrypt('123456789'),
            ]);

            $newUser->attachRole($superadminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'admin@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'Admin',
                'email'    => 'admin@gmail.com',
                'password' => bcrypt('123456789'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                if ($permission->model != 'Role') {
                    $newUser->attachPermission($permission);
                }
            }
        }

        if (config('roles.models.defaultUser')::where('email', '=', 'user@gmail.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'User',
                'email'    => 'user@gmail.com',
                'password' => bcrypt('123456789'),
            ]);

            $newUser->attachRole($userRole);
        }
    }
}
