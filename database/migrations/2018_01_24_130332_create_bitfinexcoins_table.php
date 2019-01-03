<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitfinexcoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bitfinexcoins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coin', 12)->index();
            $table->float('min_price', 14, 8);
            $table->float('max_price', 14, 8);
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
        Schema::dropIfExists('bitfinexcoins');
    }
}
