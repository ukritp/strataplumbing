<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// https://laravel-news.com/2015/10/learn-to-use-model-factories-in-laravel-5-1/
// https://mattstauffer.co/blog/better-integration-testing-in-laravel-5.1-model-factories
// https://scotch.io/tutorials/generate-dummy-laravel-data-with-model-factories
// https://github.com/fzaninotto/Faker#fakerprovideren_usphonenumber

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
// CLIENT FACTORY
$factory->define(App\Client::class, function (Faker\Generator $faker) {
    $city = $faker->randomElement($array = array ('Vancouver','Burnaby','Surrey','Richmond','Delta','North Vancouver',
        'Coquitlam','Langley'));
    $initial_number = $faker->randomElement($array = array ('604','778'));
    return [

        'company_name'       => $faker->company,
        'first_name'         => $faker->firstName,
        'last_name'          => $faker->lastName,
        'title'              => $faker->jobTitle,
        'mailing_address'    => $faker->streetAddress,
        'mailing_city'       => $city,
        'mailing_province'   => 'BC',
        'mailing_postalcode' => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'buzzer_code'        => $faker->randomNumber,
        'billing_address'    => $faker->streetAddress,
        'billing_city'       => $city,
        'billing_province'   => 'BC',
        'billing_postalcode' => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'home_number'        => $initial_number.$faker->numerify('#######'),
        'cell_number'        => $initial_number.$faker->numerify('#######'),
        'work_number'        => $initial_number.$faker->numerify('#######'),
        'fax_number'         => $initial_number.$faker->numerify('#######'),
        'email'              => $faker->email,
        'alternate_email'    => $faker->email,
        'quoted_rates'       => $faker->word,
        'property_note'      => $faker->realText(),
    ];
});
// SITE FACTORY
$factory->define(App\Site::class, function (Faker\Generator $faker) {
    $city = $faker->randomElement($array = array ('Vancouver','Burnaby','Surrey','Richmond','Delta','North Vancouver',
        'Coquitlam','Langley'));
    $initial_number = $faker->randomElement($array = array ('604','778'));
    return [

        'mailing_address'    => $faker->streetAddress,
        'mailing_city'       => $city,
        'mailing_province'   => 'BC',
        'mailing_postalcode' => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'buzzer_code'        => $faker->randomNumber,
        'alarm_code'         => $faker->randomNumber,
        'lock_box'           => $faker->word,
        'lock_box_location'  => $faker->word,
        'billing_address'    => $faker->streetAddress,
        'billing_city'       => $city,
        'billing_province'   => 'BC',
        'billing_postalcode' => 'V'.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit.$faker->randomLetter.$faker->randomDigit,
        'property_note'      => $faker->realText(),
    ];
});

// CONTACTS FACTORY - SITE
$factory->defineAs(App\Contact::class, 'siteContact', function (Faker\Generator $faker) {
    $site_ids = \DB::table('sites')->select('id')->get();
    $site_id = $faker->randomElement($site_ids)->id;
    $initial_number = $faker->randomElement($array = array ('604','778'));
    return [
        'company_name'    => $faker->company,
        'first_name'      => $faker->firstName,
        'last_name'       => $faker->lastName,
        'title'           => $faker->jobTitle,

        'home_number'     => $initial_number.$faker->numerify('#######'),
        'cell_number'     => $initial_number.$faker->numerify('#######'),
        'work_number'     => $initial_number.$faker->numerify('#######'),
        'fax_number'      => $initial_number.$faker->numerify('#######'),

        'email'           => $faker->email,
        'alternate_email' => $faker->email,

        'site_id'         => $site_id,
    ];
});

// JOB FACTORY - CLIENT
$factory->defineAs(App\Job::class, 'clientToJob', function (Faker\Generator $faker) {
    $client_ids = \DB::table('clients')->select('id')->get();
    $client_id = $faker->randomElement($client_ids)->id;
    $project_manager = $faker->randomElement($array = array ('PC','JB','JG'));
    $is_estimate = $faker->randomElement($array = array ('0','1'));
    return [
        'project_manager'       => $project_manager,
        'is_estimate'           => $is_estimate,
        'scope_of_works'        => $faker->realText(),
        'purchase_order_number' => $faker->numerify('#####'),
        //'first_name'          => $faker->firstName,
        //'last_name'           => $faker->firstName,
        //'cell_number'         => $faker->randomNumber(7),
        'client_id'             => $client_id,
    ];
});
// JOB FACTORY - SITE
$factory->defineAs(App\Job::class, 'siteToJob', function (Faker\Generator $faker) {

    $site_ids = \DB::table('sites')->select('id')->get();
    $site_id = $faker->randomElement($site_ids)->id;
    $project_manager = $faker->randomElement($array = array ('PC','JB','JG'));
    return [
        'project_manager'       => $project_manager,
        'scope_of_works'        => $faker->realText(),
        'purchase_order_number' => $faker->numerify('###'),
        'site_id'               => $site_id,
        'client_id'             => App\Site::find($site_id)->client_id,
    ];
});

// TECHNICIAN FACTORY
$factory->define(App\Technician::class, function (Faker\Generator $faker) {
    $job_ids = \DB::table('jobs')->select('id')->get();
    $job_id = $faker->randomElement($job_ids)->id;
    $user_ids = \DB::table('users')->select('users.id')
                    ->join('user_roles', function ($join) {
                        $join->on('users.id', '=', 'user_roles.user_id')
                        ->where('user_roles.role_id', '=', 3);
                    })
                    ->get();
    $user_id = $faker->randomElement($user_ids)->id;
    $equipment_left_on_site = $faker->randomElement($array = array (0,1));
    $equipment_name ='';
    if($equipment_left_on_site==1){
        $equipment_name = $faker->word();
    }
    return [
        'pendinginvoiced_at'     => $faker->dateTimeBetween($startDate = '-1 week', $endDate = 'now', $timezone = date_default_timezone_get()),
        //'technician_name'        => $faker->firstName(),
        'technician_name'        => App\User::find($user_id)->name,
        'tech_details'           => $faker->realText(),
        'flushing_hours'         => $faker->randomDigitNotNull(),
        'camera_hours'           => $faker->randomDigitNotNull(),
        'main_line_auger_hours'  => $faker->randomDigitNotNull(),
        'equipment_left_on_site' => $equipment_left_on_site,
        'equipment_name'         => $equipment_name,
        'user_id'                => $user_id,
        ];
});

// MATERIAL FACTORY
$factory->define(App\Material::class, function (Faker\Generator $faker) {
    $technician_ids = \DB::table('technicians')->select('id')->get();
    $technician_id = $faker->randomElement($technician_ids)->id;
    return [
        'material_name'         => $faker->word(),
        'material_quantity'     => $faker->randomDigitNotNull(),
        'technician_id'         => $technician_id,
        ];
});
