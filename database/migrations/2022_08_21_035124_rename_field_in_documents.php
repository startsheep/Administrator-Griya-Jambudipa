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
        Schema::table('documents', function (Blueprint $table) {
            $table->renameColumn('customer_id', 'documentable_id');
            $table->renameColumn('document', 'documentable_type');
            $table->string('document_path')->after('document')->nullable();
            $table->string('document_name')->after('document_path')->nullable();
        });
    }
};
