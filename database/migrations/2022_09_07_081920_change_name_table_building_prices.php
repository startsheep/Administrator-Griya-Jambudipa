<?php

use App\Models\BasicPriceCategory;
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
        Schema::rename('building_prices', 'basic_prices');
        Schema::rename('building_price_categories', 'basic_price_categories');
        Schema::table('basic_price_categories', function (Blueprint $table) {
            $table->string("section", 50)->nullable()->after('category');
        });

        Schema::table('basic_prices', function (Blueprint $table) {
            $table->foreignIdFor(BasicPriceCategory::class)->nullable()->after('id');
        });
    }
};
