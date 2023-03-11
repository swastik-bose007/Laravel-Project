<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_media_library', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->string('type');
            $table->string('media_url');
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
        Schema::table('tk_media_library', function (Blueprint $table) {

            $table->dropIfExists('tk_media_library');

        });

    }
}
