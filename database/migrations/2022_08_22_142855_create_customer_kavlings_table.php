<?php

use App\Models\Kavling;
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
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('kavling_id');
        });

        Schema::create('customer_kavlings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kavling::class)->nullable();
            $table->integer('customerable_id')->nullable();
            $table->string('customerable_type')->nullable();
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
        Schema::dropIfExists('customer_kavlings');
    }
};
