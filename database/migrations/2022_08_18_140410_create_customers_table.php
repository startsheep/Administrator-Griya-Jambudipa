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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->integer('kavling_id')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('profession', 50)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
