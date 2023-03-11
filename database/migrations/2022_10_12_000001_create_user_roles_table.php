<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->text('description');
            $table->string('slug', 100)->unique();
            $table->tinyInteger('status')->default(1);
            $table->longText('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down() {
        Schema::dropIfExists('tk_user_roles');
    }
}
