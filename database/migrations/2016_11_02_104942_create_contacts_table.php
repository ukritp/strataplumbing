<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('company_name')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();

            $table->string('home_number',10)->nullable();
            $table->string('cell_number',10)->nullable();
            $table->string('work_number',10)->nullable();
            $table->string('fax_number',10)->nullable();
            $table->string('email')->nullable();
            $table->string('alternate_email')->nullable();

            $table->integer('site_id')->unsigned()->nullable();
            $table->foreign('site_id')->references('id')->on('sites');

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
        Schema::drop('contacts');
    }
}
