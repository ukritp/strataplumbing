<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();

        $this->call(RolesTableSeeder::class);

        $role_admin = Role::where('name','Admin')->first();
        $role_owner = Role::where('name','Owner')->first();
        $role_tech = Role::where('name','Technician')->first();

        $owner = new User;
        $owner->name = 'Peter';
        $owner->email = 'peter@strataplumbing.com';
        $owner->password = bcrypt('peter@123Passw0rd');
        $owner->save();
        $owner->roles()->attach($role_owner);

        $admin = new User;
        $admin->name = 'Trinh';
        $admin->email = 'trinh@strataplumbing.com';
        $admin->password = bcrypt('trinh@123Passw0rd');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->name = 'Vivien';
        $admin->email = 'vivien@strataplumbing.com';
        $admin->password = bcrypt('vivien@123Passw0rd');
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
        $tech->password = bcrypt('tech@123Passw0rd');
        $tech->save();
        $tech->roles()->attach($role_tech);

        $admin = new User;
        $admin->name = 'Albina';
        $admin->email = 'albina@castlecs.com';
        $admin->password = bcrypt('castlecs');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->name = 'Ukrit';
        $admin->email = 'upornpatanapaisarnkul@castlecs.com';
        $admin->password = bcrypt('castlecs');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User;
        $admin->name = 'Michal';
        $admin->email = 'mfupso@castlecs.com';
        $admin->password = bcrypt('castlecs');
        $admin->save();
        $admin->roles()->attach($role_admin);

        // $this->call(UsersTableSeeder::class);

        $this->call( 'ClientTableSeeder' );
        $this->call( 'JobTableSeeder' );
        $this->call( 'ContactsTableSeeder' );
        $this->call( 'MaterialTableSeeder' );

        Model::reguard();
    }
}
