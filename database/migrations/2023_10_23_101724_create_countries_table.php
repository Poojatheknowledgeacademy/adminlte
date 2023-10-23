<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->integer('tka_id');
            $table->string('name')->default('');
            $table->string('currency')->default('');
            $table->string('currency_currency_title')->default('');
            $table->string('currency_symbol')->default('');
            $table->string('currency_symbol_html')->nullable('');
            $table->string('iso3')->default('');
            $table->string('sales_tax_label')->default('');
            $table->boolean('charge_vat')->default(0);
            $table->decimal('vat_percentage', 5, 2)->default(0);
            $table->decimal('vat_amount_elearning', 8, 2)->default(0);
            $table->boolean('conversion_required')->default(0);
            $table->decimal('exchange_rate', 8, 2)->default(0);
            $table->string('opening_hours')->default('');
            $table->string('opening_days')->default('');
            $table->string('date_format')->default('');
            $table->string('isAdvert')->default('');
            $table->string('map_id')->default('');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
};

