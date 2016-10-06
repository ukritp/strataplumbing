<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_invoices', function (Blueprint $table) {
            $table->increments('id');

            $table->text('description');
            $table->string('labor_description')->nullable();
            $table->string('total_hours');
            $table->string('hourly_rates');

            $table->string('date',2);
            $table->string('month',2);
            $table->string('year',4);

            $table->boolean('first_half_hour')->default(false);
            $table->string('first_half_hour_amount')->nullable();
            $table->boolean('first_one_hour')->default(false);
            $table->string('first_one_hour_amount')->nullable();

            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs');

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
        Schema::drop('pending_invoices');
    }
}
