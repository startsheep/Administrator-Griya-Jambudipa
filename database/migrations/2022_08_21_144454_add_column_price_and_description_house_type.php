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
        Schema::table('house_types', function (Blueprint $table) {
            $table->text('description')->nullable()->after('house_type');
            $table->string('price', 15)->nullable()->after('description');
        });
    }
};
