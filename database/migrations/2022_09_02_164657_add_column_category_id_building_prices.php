<?php

use App\Models\BuildingPriceCategory;
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
        Schema::table('building_prices', function (Blueprint $table) {
            $table->foreignIdFor(BuildingPriceCategory::class)->nullable()->after('id');
        });
    }
};
