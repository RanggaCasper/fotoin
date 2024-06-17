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
        Schema::create('categorys', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('icon');
            $table->longText('image');
            $table->timestamps();
        });

        Schema::create('catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('title_name');
            $table->longText('description');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categorys');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name');
            $table->string('price');
            $table->longText('description');
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->timestamps();
        });

        Schema::create('portofolio_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('path_image');
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->timestamps();
        });

        Schema::create('feedback_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('rate', 1);
            $table->string('feedback')->nullable();
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
    }
};
