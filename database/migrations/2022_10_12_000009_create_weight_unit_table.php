<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightUnitTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_weight_unit', function (Blueprint $table) {
            $table->id();
            $table->string('weight_unit_name', 50);
            $table->string('symbol', 50);
            $table->tinyInteger('status')->default(0);
            $table->string('slug', 100);
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
        Schema::dropIfExists('tk_weight_unit');
    }
}
