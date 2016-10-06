<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTechniciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamp('pendinginvoiced_at')->nullable();
            $table->string('technician_name');
            $table->text('tech_details');
            $table->string('flushing_hours',5)->nullable();
            $table->string('camera_hours',5)->nullable();
            $table->string('main_line_auger_hours',5)->nullable();
            $table->string('other_hours',5)->nullable();

            $table->string('flushing_hours_cost',50)->nullable();
            $table->string('camera_hours_cost',50)->nullable();
            $table->string('main_line_auger_hours_cost',50)->nullable();
            $table->string('other_hours_cost',50)->nullable();

            $table->text('notes')->nullable();
            $table->boolean('equipment_left_on_site')->default(false);
            $table->string('equipment_name')->nullable();

            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('jobs');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('technicians');
    }
}
