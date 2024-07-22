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
        Schema::create('suspend_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reporter_id'); // ID pelapor
            $table->foreign('reporter_id')->references('id')->on('users');
            $table->unsignedBigInteger('reported_id'); // ID yang dilaporkan
            $table->foreign('reported_id')->references('id')->on('users');
            $table->longText('note');
            $table->longText('proff');
            $table->enum('status',['PENDING','ACCEPTED', 'REJECTED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suspend_request');
    }
};
