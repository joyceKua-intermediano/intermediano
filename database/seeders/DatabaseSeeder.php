<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        try {
            $admin = User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            $admin = User::whereEmail("admin@admin.com")->first();
        }

        // roles
        $roles = ["Admin", "Business Developer", "User"];
        foreach ($roles as $role) {
            $roleCreated = Role::whereName($role)->first();
            if (!$roleCreated) Role::query()->create(["name"=>$role]);
        }

        // $permissions 
        $permissions = [
            "Add User",
            "Show User",
            "List User",
            "Edit User",
            "Delete User",
            
            "Add Lead",
            "Show Lead",
            "List Lead",
            "Edit Lead",
            "Delete Lead",

            "Add Company",
            "Show Company",
            "List Company",
            "Edit Company",
            "Delete Company",

            "Add Contact",
            "Show Contact",
            "List Contact",
            "Edit Contact",
            "Delete Contact",
        ];

        foreach ($permissions as $permission) {
            $permissionCreated = Permission::whereName($permission)->first();
            if (!$permissionCreated) {
                Permission::query()->create(["name"=>$permission]);
            }
        }

        // add all permissions to admin
        $permissions = Permission::pluck("name");
        $adminRole = Role::whereName("Admin")->first();
        $adminRole->syncPermissions($permissions);

        // add admin role do admin user
        $admin->assignRole($adminRole->name);
    }
}
