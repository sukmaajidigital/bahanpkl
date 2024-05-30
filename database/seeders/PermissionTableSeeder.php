<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $listPermission = [];
        $authorities = config('permission.authorities'); 
        $adminPermissions = [];

        foreach($authorities as  $label => $permissions){
            foreach($permissions as $permission){
                $listPermission[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                //admin
                $adminPermissions[] = $permission;
            }
        }

        //insert Permission
        Permission::insert($listPermission);
        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $admin->givePermissionTo($adminPermissions);
        $userAdmin = User::find(1)->assignRole("Admin");
    }
}
