<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('email');
            $table->string('site');

            $table->unsignedTinyInteger('starttime');
            $table->unsignedTinyInteger('stopttime');
            $table->unsignedInteger('check');
            $table->unsignedInteger('kitchen');
            $table->string('address');

            $table->text('description');

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
        Schema::dropIfExists('services');
    }
}
