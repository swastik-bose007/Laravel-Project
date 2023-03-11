<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */


    public function up() {
        Schema::create('tk_users', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();

            // user details
            $table->bigInteger('created_by')->default(0);
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->string('adhar_no', 12)->nullable();
            $table->string('pan_no', 10)->nullable()->unique();
            $table->string('cin_no', 21)->nullable()->unique();
            $table->string('acc_no', 20)->nullable();
            $table->string('area', 20)->nullable();
            $table->string('district', 20)->nullable();
            $table->string('pincode', 20)->nullable();
            $table->string('registration_no', 21)->nullable();
            $table->string('bazar_mandi_name', 50)->nullable();
            $table->string('bazar_mandi_type', 15)->nullable();
            $table->string('sufal_store_name', 50)->nullable();
            $table->string('sufal_store_type', 15)->nullable();
            $table->string('registered_store_attendant_first_name', 40)->nullable();
            $table->string('registered_store_attendant_last_name', 40)->nullable();
            $table->string('registered_store_attendant_adhar_no', 12)->nullable();
            $table->string('registered_store_attendant_phone', 20)->nullable();

            // login details
            $table->string('phone', 20)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            
            $table->tinyInteger('user_type')->default(3);
            $table->string('profile_picture_url', 100)->default(env('DEFAULT_USER_IMAGE'));
            
            $table->tinyInteger('status')->default(0);
            $table->longText('tags')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('tk_users');
    }
}
