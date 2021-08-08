<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('example_update', function (Blueprint $table) {
            $table->renameColumn('nama', 'name');
            $table->renameColumn('keterangan', 'description');
            $table->text('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('example_update', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
