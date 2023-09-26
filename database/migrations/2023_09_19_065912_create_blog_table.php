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
        Schema::create('blog', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('title');
            $table->text('short_description');
            $table->text('summary');
            $table->string('featured_img1')->nullable();
            $table->string('featured_img2')->nullable();
            $table->string('author_name');
            $table->boolean('is_popular');
            $table->integer('views_count')->nullable();
            $table->integer('order_sequence')->nullable();
            $table->date('added_date');
            $table->integer('created_by');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog');
    }
};
