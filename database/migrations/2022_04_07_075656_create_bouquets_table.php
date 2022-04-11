<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBouquetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bouquets', function (Blueprint $table) {
            $table->id();
            $table->string('bouequetName');
            $table->string('bouequetDescription');
            $table->double('bouequetPrice');
            $table->string('bouquetImage');
            $table->timestamps();
            $table->enum('type', ['lilies', 'orchids','roses','tulip','peony','sunflower','carnation'])->default('lilies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bouquets');
    }
}
