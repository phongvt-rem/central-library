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
        Schema::table('books', function (Blueprint $table) {
            $table->id()->comment('Primary key')->change();
            $table->string('title')->comment('Book title')->change();
            $table->string('cover_url')->comment('Cover image URL')->change();
            $table->foreignId('author_id')->comment('Author ID')->change();
            $table->foreignId('category_id')->comment('Category ID')->change();
            $table->year('published_year')->nullable()->comment('Year the book was published')->change();
            $table->timestamp('created_at')->nullable()->comment('Record creation time')->change();
            $table->timestamp('updated_at')->nullable()->comment('Last update time')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->id()->change();
            $table->string('title')->change();
            $table->string('cover_url')->change();
            $table->foreignId('author_id')->constrained()->change();
            $table->foreignId('category_id')->constrained()->change();
            $table->year('published_year')->nullable()->change();
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
    }
};
