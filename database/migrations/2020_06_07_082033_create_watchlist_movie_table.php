<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchlistMovieTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('WatchlistMovie', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('watched');
            $table->unsignedInteger('watchlistFk');
            $table->unsignedInteger('movieFk');

            $table->foreign('watchlistFk')->references('id')->on('Watchlist')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('movieFk')->references('id')->on('Movie')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('WatchlistMovie');
    }
}
