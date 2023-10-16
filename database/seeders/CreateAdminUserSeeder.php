<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
         ];


         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission,'guard_name'=>'web','description'=>$permission,'is_active'=>1]);
         }
        Auth::loginUsingId(1);
        $user = User::create([
            'name' => 'ankita',
            'email' => 'ankita@gmail.com',
            'password' => bcrypt('ankita123'),
            'created_by' =>1
        ]);

        $role = Role::create(['name' => 'admin','guard_name'=>'web','description'=>'adminpermission','is_active'=>1]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
