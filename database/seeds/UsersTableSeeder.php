'<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\User::class, 1)->create();

        $role_admin = Role::where('name','Admin')->first();
        $role_owner = Role::where('name','Owner')->first();
        $role_tech = Role::where('name','Technician')->first();

        $owner = new User;
        $owner->name = 'Peter';
        $owner->email = 'peter@strataplumbing.com';
        $owner->password = bcrypt('123Passw0rd');
        $owner->save();
        $owner->roles()->attach($role_owner);

        $admin = new User;
        $admin->name = 'Trinh';
        $admin->email = 'trinh@strataplumbing.com';
        $admin->password = bcrypt('123Passw0rd');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->name = 'Vivien';
        $admin->email = 'vivien@strataplumbing.com';
        $admin->password = bcrypt('123Passw0rd');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->name = 'Johan';
        $admin->email = 'johan@strataplumbing.com';
        $admin->password = bcrypt('123Passw0rd');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $tech = new User;
        $tech->name = 'Technician';
        $tech->email = 'info@strataplumbing.com';
        $tech->password = bcrypt('tech');
        $tech->save();
        $tech->roles()->attach($role_tech);

        $admin = new User;
        $admin->name = 'Ukrit';
        $admin->email = 'upornpatanapaisarnkul@castlecs.com';
        $admin->password = bcrypt('castlecs');
        $admin->save();
        $admin->roles()->attach($role_admin);

        // $admin = new User;
        // $admin->name = 'Admin';
        // $admin->email = 'admin@example.com';
        // $admin->password = bcrypt('admin');
        // $admin->save();
        // $admin->roles()->attach($role_admin);

        // $owner = new User;
        // $owner->name = 'Owner';
        // $owner->email = 'owner@example.com';
        // $owner->password = bcrypt('owner');
        // $owner->save();
        // $owner->roles()->attach($role_owner);

        // $tech = new User;
        // $tech->name = 'Tech';
        // $tech->email = 'tech@example.com';
        // $tech->password = bcrypt('tech');
        // $tech->save();
        // $tech->roles()->attach($role_tech);

        // $tech = new User;
        // $tech->name = 'Ukrit';
        // $tech->email = 'ukrit@castlecs.com';
        // $tech->password = bcrypt('castlecs');
        // $tech->save();
        // $tech->roles()->attach($role_tech);

        // $tech = new User;
        // $tech->name = 'Zandro';
        // $tech->email = 'zandro@castlecs.com';
        // $tech->password = bcrypt('castlecs');
        // $tech->save();
        // $tech->roles()->attach($role_tech);

        // $tech = new User;
        // $tech->name = 'Mike';
        // $tech->email = 'mike@castlecs.com';
        // $tech->password = bcrypt('castlecs');
        // $tech->save();
        // $tech->roles()->attach($role_tech);

    }
}
'