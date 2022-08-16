<?php

use App\Models\Position;
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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Position::class)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->text('address')->nullable();
            $table->dateTime('entry_date')->nullable();
            $table->string('image')->nullable();
            $table->smallInteger('is_active')->nullable();
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
        Schema::dropIfExists('employees');
    }
};
