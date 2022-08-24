<?php

use App\Models\Customer;
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
        Schema::table('customer_kavlings', function (Blueprint $table) {
            $table->dropColumn('kavling_id');
            $table->dropColumn('customerable_id');
            $table->dropColumn('customerable_type');
        });

        Schema::table('customer_kavlings', function (Blueprint $table) {
            $table->foreignIdFor(Kavling::class);
            $table->foreignIdFor(Customer::class);
        });
    }
};
