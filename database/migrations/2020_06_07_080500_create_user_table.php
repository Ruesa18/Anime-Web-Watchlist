<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedInteger('roleFk')->nullable();

            $table->foreign('roleFk')->references('id')->on('Role')->onUpdate('CASCADE')->onDelete('SET NULL');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('User');
    }
}
