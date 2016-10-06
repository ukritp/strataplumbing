<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_admin = new Role();
        $role_admin->name = 'Admin';
        $role_admin->description = 'This is for office admins';
        $role_admin->save();

        $role_owner = new Role();
        $role_owner->name = 'Owner';
        $role_owner->description = 'This is for owner';
        $role_owner->save();

        $role_tech = new Role();
        $role_tech->name = 'Technician';
        $role_tech->description = 'This is for technicians';
        $role_tech->save();
    }
}
