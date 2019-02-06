<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'eselon2']);
        Role::create(['name' => 'eselon3']);
        Role::create(['name' => 'eselon4']);
        Role::create(['name' => 'fungsional_stat']);
        Role::create(['name' => 'fungsional_prakom']);
        Role::create(['name' => 'staff']);

        Permission::create(['name' => 'Lihat CKP Bawahan']);
        Permission::create(['name' => 'Lihat Log Book Bawahan']);
        Permission::create(['name' => 'Approval CKP Bawahan']);
        Permission::create(['name' => 'Approval Log Book Bawahan']);
    }
}
