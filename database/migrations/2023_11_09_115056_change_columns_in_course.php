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
        Schema::table('courses', function (Blueprint $table) {
            $table->Integer('parentCourseId')->nullable();
            $table->string('url')->nullable();
            $table->string('coursecode')->nullable();
            $table->tinyInteger('is_weekend')->nullable();
            $table->tinyInteger('is_module')->nullable();
            $table->tinyInteger('is_technical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('parentCourseId');
            $table->dropColumn('url');
            $table->dropColumn('coursecode');
            $table->dropColumn('is_weekend');
            $table->dropColumn('is_module');
            $table->dropColumn('is_technical');
        });
    }
};
