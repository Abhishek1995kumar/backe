<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('admin_code')->nullable();
            $table->string('company');
            $table->string('role');
            $table->string('experience');
            $table->date('doj')->nullable();
            $table->date('doe')->nullable();
            $table->decimal('salary', 10, 2);
            $table->string('project_title')->nullable();
            $table->string('description')->nullable();
            $table->longText('documents')->nullable();
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
        Schema::dropIfExists('admin_experiences');
    }
};
