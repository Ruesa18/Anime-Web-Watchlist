<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Series', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->date('airDate');
            $table->unsignedInteger('studioFk');

            $table->foreign('studioFk')->references('id')->on('Studio')->onUpdate('CASCADE')->onDelete('RESTRICT');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Series');
    }
}
