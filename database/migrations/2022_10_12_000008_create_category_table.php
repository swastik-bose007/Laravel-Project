<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_category', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('name', 60);
            $table->string('slug', 100);
            $table->longtext('description',100)->nullable();
            $table->tinyInteger('priority');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('is_editable')->default(1);
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
    public function down()
    {
        Schema::dropIfExists('tk_category');
    }
}
