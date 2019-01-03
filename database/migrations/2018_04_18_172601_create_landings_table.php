<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->json('buttons')->nullable()->default(null);
            $table->unsignedSmallInteger('ratio')->default(0);
            $table->unsignedInteger('click')->default(0);

            $table->timestamps();

            $table->timestamp('start')->nullable()->index();
            $table->timestamp('stop')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landings');
    }
}
