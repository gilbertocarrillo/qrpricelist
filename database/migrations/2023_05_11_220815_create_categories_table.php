<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->string('description')->nullable();

            $table->ulid('pricelist_id');
            $table->foreign('pricelist_id')->references('id')->on('pricelists')->onDelete('cascade');

             #https://stackoverflow.com/questions/18427391/laravel-migrations-self-referencing-foreign-key-general-error-1005-cant-create
            $table->ulid('parent_id')->nullable();

            $table->timestamps();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
