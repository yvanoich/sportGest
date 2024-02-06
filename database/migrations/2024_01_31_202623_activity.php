<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Activity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->id();
            $table->string('ident', 32)->unique();
            $table->string('util', 32);
            $table->string('name', 100);
            $table->float('distance');
            $table->time('duration');
            $table->integer('height')->nullable();
            $table->string('sport', 32);
            $table->timestamp('date');
            $table->string('description', 5000)->nullable();
            $table->timestamps();

            // Clé étrangère
            $table->foreign('sport')->references('ident')->on('sport')->onDelete('cascade');
            $table->foreign('util')->references('ident')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity');
    }
}
