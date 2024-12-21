<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('admin_designation_masters', function (Blueprint $table) {
            $table->id();
            $table->string('designation');
            $table->string('description');
            $table->boolean('status')->comment('1=same, 2=change')->default(1);
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
        Schema::dropIfExists('admin_designation_masters');
    }
};
