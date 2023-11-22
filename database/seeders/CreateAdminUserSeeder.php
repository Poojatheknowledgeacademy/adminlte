<?php

namespace Database\Seeders;

use App\Models\LogActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $modules=['user','category','blog','topic','course','tag','role','permission','module'];
        $permissions = [
            'list',
            'insert',
            'update',
            'delete',
        ];


        foreach ($modules as $module) {
           $module = Module::create(['name'=>$module,'is_active'=>1]);

           foreach ($permissions as $permission) {
            Permission::create([
                'module_id' => $module->id,
                'name' => strtolower($module->name) . "-" . $permission,
                'guard_name' => 'web',
                'description' => $permission,
                'is_active' => 1
            ]);
           }
        }

        Auth::loginUsingId(1);
        $user = User::Create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user123'),
            'created_by' =>1
        ]);

       

        $role = Role::create(['name' => 'Admin','guard_name'=>'web','description'=>'adminpermission','is_active'=>1]);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
