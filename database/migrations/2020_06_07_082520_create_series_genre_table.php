<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesGenreTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('SeriesGenre', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('seriesFk');
            $table->unsignedInteger('genreFk');

            $table->foreign('seriesFk')->references('id')->on('Series')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('SeriesGenre');
    }
}
