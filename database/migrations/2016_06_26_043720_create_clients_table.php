<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->string('strata_plan_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('mailing_address');
            $table->string('mailing_city',50)->nullable();
            $table->string('mailing_province',50)->nullable();
            $table->string('mailing_postalcode',6)->nullable();

            $table->string('buzzer_code')->nullable();
            $table->string('alarm_code')->nullable();
            $table->string('lock_box')->nullable();
            $table->string('lock_box_location')->nullable();

            $table->string('billing_address')->nullable();
            $table->string('billing_city',50)->nullable();
            $table->string('billing_province',50)->nullable();
            $table->string('billing_postalcode',6)->nullable();
            $table->string('home_number',10)->nullable();
            $table->string('cell_number',10)->nullable();
            $table->string('work_number',10)->nullable();
            $table->string('fax_number',10)->nullable();

            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('quoted_rates')->nullable();
            $table->text('property_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
