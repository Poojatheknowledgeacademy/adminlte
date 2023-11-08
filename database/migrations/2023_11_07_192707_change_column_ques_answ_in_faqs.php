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
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question')->nullable()->change();
            $table->text('answer')->nullable()->change();
            $table->unsignedBigInteger('created_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->text('question')->change();
            $table->text('answer')->change();
            $table->unsignedBigInteger('created_by')->change();
        });
    }
};
