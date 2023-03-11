<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFpoTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_fpo', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('fpo_type', 60);
            $table->string('produce_type', 60);
            $table->integer('quantity')->default(0);
            $table->string('slot_no', 60);
            $table->string('area', 20)->nullable();
            $table->string('district', 20)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('tk_fpo');
    }
}
