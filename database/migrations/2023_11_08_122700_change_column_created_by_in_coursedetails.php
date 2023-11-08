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
        Schema::table('coursedetails', function (Blueprint $table) {
            $table->text('pre_requisite')->nullable()->change();
            $table->text('whats_included')->nullable()->change();
            $table->text('who_should_attend')->nullable()->change();
            $table->integer('added_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coursedetails', function (Blueprint $table) {
            $table->text('pre_requisite')->change();
            $table->text('whats_included')->change();
            $table->text('who_should_attend')->change();
            $table->integer('added_by')->change();
        });
    }
};
