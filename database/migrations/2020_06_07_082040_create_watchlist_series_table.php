<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWatchlistSeriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('WatchlistSeries', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('watched');
            $table->unsignedInteger('watchlistFk');
            $table->unsignedInteger('seriesFk');

            $table->foreign('watchlistFk')->references('id')->on('Watchlist')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('seriesFk')->references('id')->on('Series')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('WatchlistSeries');
    }
}
