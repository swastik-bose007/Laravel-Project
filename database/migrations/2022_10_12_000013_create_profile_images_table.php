<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_profile_images', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('profile_image_url');
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
        Schema::table('tk_profile_images', function (Blueprint $table) {

            $table->dropIfExists('tk_profile_images');

        });

    }
}
