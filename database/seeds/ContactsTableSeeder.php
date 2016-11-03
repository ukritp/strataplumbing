<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Contacts from site
        factory(App\Contact::class, 'siteContact' , 7)->create();
    }
}
