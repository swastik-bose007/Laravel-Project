<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Helper
use App\Helpers\CommonFunction;

class CreateProduceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_produce', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->string('slug', 100)->unique();
            $table->bigInteger('produce_name_id');
            $table->bigInteger('produce_variant_id')->nullable();
            $table->string('type', 60);
            $table->integer('quantity')->default(0);
            $table->integer('stock_left')->default(0);
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
        Schema::dropIfExists('tk_produce');
    }
}
