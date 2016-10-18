<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_estimate')->default(false);

            $table->string('project_manager',50)->nullable();
            $table->text('scope_of_works');
            $table->string('purchase_order_number', 50)->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('cell_number', 10)->nullable();

            $table->string('labor_discount', 2)->default(0)->nullable();
            $table->string('material_discount',2)->default(0)->nullable();

            $table->string('price_adjustment_title')->nullable();
            $table->boolean('price_adjustment_type')->default(false);
            $table->string('price_adjustment_amount')->default(0)->nullable();

            $table->boolean('status')->default(false);
            $table->string('approval_status')->nullable();
            $table->text('approval_note')->nullable();
            $table->timestamp('invoiced_at')->nullable();

            $table->boolean('is_trucked')->default(false);
            $table->string('truck_services_amount')->nullable();

            $table->integer('site_id')->unsigned()->nullable();
            $table->foreign('site_id')->references('id')->on('sites');
            $table->integer('client_id')->unsigned()->nullable();
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
        Schema::drop('jobs');
    }
}
