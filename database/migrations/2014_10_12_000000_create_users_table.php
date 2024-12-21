<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->nullable()->comment('1=active, 2=inactive, 0=rejected, 3=pending')->default(0);
            $table->tinyInteger('login_status')->nullable()->comment("1=logged in, 0=logged out");
            $table->string('default_password')->nullable();
            $table->string('password');
            $table->string('gender', 12)->nullable()->comment("1=Male, 2=Female, 3=Other");
            $table->text('aadhar_card')->nullable();
            $table->text('addressproof')->nullable();
            $table->text('area_location')->nullable();
            $table->string('landmark', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('pincode')->nullable();
            $table->timestamp('password_modified_at')->nullable();
            $table->string('old_password_1')->comment("User first time change password")->nullable();
            $table->string('old_password_2')->comment("User second time change password")->nullable();
            $table->string('old_password_3')->comment("User third time change password")->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
