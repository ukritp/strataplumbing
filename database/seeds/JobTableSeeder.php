<?php

use Illuminate\Database\Seeder;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //factory(App\Job::class, 10)->create();

        // Jobs from client
        factory(App\Job::class, 'clientToJob' , 5)->create()->each(function($jobs) {
            $jobs->technicians()->saveMany(factory(App\Technician::class,3)->make());
        });

        // Jobs from site
        factory(App\Job::class,'siteToJob', 3)->create()->each(function($jobs) {
            $jobs->technicians()->saveMany(factory(App\Technician::class,2)->make());
        });


    }
}
