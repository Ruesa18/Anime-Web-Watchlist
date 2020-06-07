<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermissionTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('RolePermission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('roleFk');
            $table->unsignedInteger('permissionFk');

            $table->foreign('roleFk')->references('id')->on('Role')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('permissionFk')->references('id')->on('Permission')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('RolePermission');
    }
}
