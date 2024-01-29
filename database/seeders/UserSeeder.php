<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $admin = User::firstOrNew(['email'=>'yousif@saifbelhasagroup.com']);
            $admin->name="yousif";
            $admin->email="yousif@saifbelhasagroup.com";
            $admin->password='sbh@2021#';
            $admin->save();

            $role=Role::updateOrCreate(['name'=>'Super Admin'],['name'=>'Super Admin']);
            $role->syncPermissions(Permission::all());
            $admin->roles()->sync([$role->id]);
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
