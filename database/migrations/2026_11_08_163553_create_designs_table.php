<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('designs', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }
    public function up(): void
    {
        Schema::create('designs', function (Blueprint $table) {
            $table->id();

            // Category Relationship
            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete();

            // Basic Information
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->longText('description')->nullable();

            // Design Information
            $table->string('featured_image')->nullable();
            $table->string('designer')->nullable();
            $table->string('collection_name')->nullable();

            // Publishing Information
            $table->string('status')->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('published_at')->nullable();

            // SEO Information
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            // Sorting
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['category_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
