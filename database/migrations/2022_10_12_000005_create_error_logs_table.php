<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErrorLogsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->text('file')->nullable();
            $table->string('line')->nullable();
            $table->text('message')->nullable();
            $table->integer('status')->default(1)->comment('0 = fixed, 1 = error');
            $table->bigInteger('count')->default(1);
            $table->json('input_request')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('fixed_by')->nullable();
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
        Schema::dropIfExists('tk_error_logs');
    }
}
