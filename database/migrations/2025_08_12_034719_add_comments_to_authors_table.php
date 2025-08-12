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
        Schema::table('authors', function (Blueprint $table) {
            $table->id()->comment('Primary key')->change();
            $table->string('name')->comment('Author name')->change();
            $table->date('birth_date')->nullable()->comment('Date of birth')->change();
            $table->timestamp('created_at')->nullable()->comment('Record creation time')->change();
            $table->timestamp('updated_at')->nullable()->comment('Last update time')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->id()->change();
            $table->string('name')->change();
            $table->date('birth_date')->nullable()->change();
            $table->timestamp('created_at')->nullable()->change();
            $table->timestamp('updated_at')->nullable()->change();
        });
    }
};
