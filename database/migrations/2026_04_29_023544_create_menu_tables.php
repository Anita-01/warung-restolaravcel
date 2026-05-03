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
      Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');     // Breakfast, Lunch, dll
        $table->string('icon');     // fa-coffee, fa-hamburger
        $table->string('subtitle'); // Popular, Special
        $table->timestamps();
    });

    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('description');
        $table->integer('price');
        $table->string('image');
        $table->timestamps();
    });
    }

};
