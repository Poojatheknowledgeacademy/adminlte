<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('log_activities', function (Blueprint $table) {
            $table->string('module');
            $table->integer('module_ref_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_activities', function (Blueprint $table) {
            $table->dropColumn('module');
            $table->dropColumn('module_ref_id');
        });
    }
};
