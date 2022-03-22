<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnToBouquetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bouquets', function (Blueprint $table) {
            //
            $table->enum('type', ['cascade', 'posy', 'round','nosegay','crescent'])->default('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bouquets', function (Blueprint $table) {
            //
        });
    }
}
