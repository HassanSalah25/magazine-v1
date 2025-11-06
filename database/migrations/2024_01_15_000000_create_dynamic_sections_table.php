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
        
        Schema::create('dynamic_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('template_type')->default('template_1'); // template_1 or template_2
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('page_type')->default('homepage'); // homepage, landingpage, etc.
            $table->timestamps();
        });

        Schema::create('dynamic_section_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_section_id')->constrained()->onDelete('cascade');
            $table->foreignId('blog_id')->constrained()->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_section_posts');
        Schema::dropIfExists('dynamic_sections');
    }
};
