<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduceVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tk_produce_variants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->bigInteger('weight_unit_code');
            $table->bigInteger('produce_name_id');
            $table->tinyInteger('status')->default(0);
            $table->string('slug', 100)->unique();
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
        Schema::table('tk_produce_variants', function (Blueprint $table) {

            $table->dropIfExists('tk_produce_variants');

        });
    }
}
