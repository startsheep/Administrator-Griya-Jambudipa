<?php

use App\Models\HouseType;
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
        Schema::create('kavlings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(HouseType::class)->nullable();
            $table->string('block', 5)->nullable();
            $table->integer('number_kavling')->nullable();
            $table->string('width_kavling', 10)->nullable();
            $table->string('length_kavling', 10)->nullable();
            $table->string('second_length_kavling', 10)->nullable();
            $table->string('area_kavling', 10)->nullable();
            $table->string('area_building', 10)->nullable();
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
        Schema::dropIfExists('kavlings');
    }
};
