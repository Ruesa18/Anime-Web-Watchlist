<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieGenreTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('MovieGenre', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('movieFk');
            $table->unsignedInteger('genreFk');

            $table->foreign('movieFk')->references('id')->on('Movie')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('genreFk')->references('id')->on('Genre')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('MovieGenre');
    }
}
