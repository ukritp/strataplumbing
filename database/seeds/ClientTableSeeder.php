<?php

use Illuminate\Database\Seeder;
use App\Client;
//https://sheepy85.wordpress.com/2014/09/19/database-seed-migration-in-laravel-5-0/

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //factory(App\Client::class, 10)->create();

        factory(App\Client::class, 5)->create()->each(function($client) {
            $client->sites()->saveMany(factory(App\Site::class,2)->make());
            //$client->jobs()->saveMany(factory(App\Job::class,1)->make());
        });

    }
}

