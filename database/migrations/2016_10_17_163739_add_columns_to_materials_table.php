<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('estimate_id')->unsigned()->nullable();
            $table->foreign('estimate_id')->references('id')->on('estimates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('materials', function (Blueprint $table) {
            //
            $table->dropForeign(['estimate_id']);
            $table->dropColumn('estimate_id');
        });
    }
}
