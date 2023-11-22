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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->Integer('tka_id');
            $table->string('name');
            $table->string('currency');
            $table->string('currency_currency_title');
            $table->string('currency_symbol');
            $table->string('currency_symbol_html')->nullable();
            $table->string('iso3')->nullable();
            $table->string('sales_tax_label');
            $table->tinyInteger('charge_vat');
            $table->decimal('vat_percentage');
            $table->decimal('vat_amount_elearning');
            $table->tinyInteger('conversion_required');
            $table->decimal('exchange_rate');
            $table->string('opening_hours')->nullable();
            $table->string('opening_days')->nullable();
            $table->string('date_format');
            $table->string('isAdvert');
            $table->string('map_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
