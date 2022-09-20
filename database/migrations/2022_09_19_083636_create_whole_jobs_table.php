<?php

use App\Models\Contractor;
use App\Models\Customer;
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
        Schema::create('whole_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contractor::class)->nullable();
            $table->foreignIdFor(Customer::class)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->foreignIdFor(HouseType::class)->nullable();
            $table->text('description')->nullable();
            $table->string('total_cost', 50)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
        Schema::dropIfExists('whole_jobs');
    }
};
