<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $permissions=[
                ['name' => 'inquiry.list'],
                ['name' => 'inquiry.listAdmin'],
                ['name' => 'inquiry.manage'],
                ['name' => 'inquiry.delete'],

                ['name' => 'switches.list'],
                ['name' => 'switches.manage'],
                ['name' => 'switches.delete'],

                ['name' => 'firewall.list'],
                ['name' => 'firewall.manage'],
                ['name' => 'firewall.delete'],

                ['name' => 'internet.list'],
                ['name' => 'internet.manage'],
                ['name' => 'internet.delete'],

                ['name' => 'nvr.list'],
                ['name' => 'nvr.manage'],
                ['name' => 'nvr.delete'],

                ['name' => 'outlet.list'],
                ['name' => 'outlet.manage'],
                ['name' => 'outlet.delete'],

                ['name' => 'domain.list'],
                ['name' => 'domain.manage'],
                ['name' => 'domain.delete'],

                ['name' => 'location.list'],
                ['name' => 'location.manage'],
                ['name' => 'location.delete'],

                ['name' => 'brand.list'],
                ['name' => 'brand.manage'],
                ['name' => 'brand.delete'],

                ['name' => 'user.list'],
                ['name' => 'user.manage'],
                ['name' => 'user.delete'],

                ['name' => 'role.list'],
                ['name' => 'role.manage'],
                ['name' => 'role.delete'],

            ];
            foreach ($permissions as $permission){
                Permission::updateOrCreate($permission,['guard_name'=>'web']);
            }
        }
        catch (\Exception $e){
            dd($e->getMessage());
        }
    }
}
