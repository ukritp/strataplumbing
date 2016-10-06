<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTechniciansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('technicians', function (Blueprint $table) {
            //
            $table->integer('pending_invoice_id')->unsigned()->nullable();
            $table->foreign('pending_invoice_id')->references('id')->on('pending_invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('technicians', function (Blueprint $table) {
            //
            $table->dropForeign(['pending_invoice_id']);
            $table->dropColumn('pending_invoice_id');
        });
    }
}
