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
            $table->Integer('duration')->nullable();
            $table->Integer('pdu')->nullable();
            $table->text('audience')->nullable();
            $table->Integer('accreditationId')->nullable();
            $table->text('exam_included')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coursedetails', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->dropColumn('pdu');
            $table->dropColumn('audience');
            $table->dropColumn('accreditationId');
            $table->dropColumn('exam_included');
        });
    }
};
