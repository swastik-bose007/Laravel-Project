<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('tk_notification', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('to_user_id');
            $table->bigInteger('from_user_id');
            $table->text('heading');
            $table->longText('message');
            $table->text('link')->nullable();
            $table->string('schedule')->default(1)->comment('0 = now, 1 = later');
            $table->dateTime('trigger_date_time')->nullable();
            $table->boolean('send_mail')->default(0)->comment('0 = false, 1 = true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tk_notification');
    }
}
