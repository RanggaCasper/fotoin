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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice');
            $table->enum('status',['COMPLETED','CANCLED','PENDING','PROCESSING'])->default('PENDING');
            $table->string('note');
            $table->ipAddress('ip');
            $table->string('user_agent');
            $table->enum('approved',['REJECTED','APPROVED','WAITING'])->default('WAITING');
            $table->string('catalog_name');
            $table->string('catalog_image');
            $table->string('package_name');
            $table->double('package_price');
            $table->string('package_description');
            $table->dateTime('booked_at');
            $table->unsignedBigInteger('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('freelance_id');
            $table->foreign('freelance_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('transaction_timelines', function (Blueprint $table) {
            $table->id();
            $table->enum('progress', ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELED'])->default('PENDING');
            $table->enum('created_by', ['SYSTEM','CLIENT', 'FREELANCER'])->default('SYSTEM');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
