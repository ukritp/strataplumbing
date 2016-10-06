<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('first_name');
            $table->string('last_name');
            $table->string('relationship')->nullable();

            $table->string('additional_contact')->nullable();

            $table->string('mailing_address');
            $table->string('mailing_city',50)->nullable();
            $table->string('mailing_province',50)->nullable();
            $table->string('mailing_postalcode',6)->nullable();
            $table->string('buzzer_code')->nullable();
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
            $table->text('property_note')->nullable();

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients');

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
        Schema::drop('sites');
    }
}
