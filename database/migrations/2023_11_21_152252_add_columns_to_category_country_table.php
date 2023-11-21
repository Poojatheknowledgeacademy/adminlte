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
        Schema::table('category_country', function (Blueprint $table) {

            $table->tinyInteger('is_popular')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('category_country', function (Blueprint $table) {

            $table->dropColumn('is_popular');
            $table->dropTimestamps();
            $table->dropSoftDeletes();
        });
    }
};
