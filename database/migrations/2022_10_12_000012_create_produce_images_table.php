<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduceImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_produce_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('produce_name_id');
            $table->string('produce_image_url');
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
        Schema::table('tk_produce_images', function (Blueprint $table) {

            $table->dropIfExists('tk_produce_images');

        });

    }
}
