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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('no_telp')->unique();
            $table->double('balance')->default('0');
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['Master', 'Admin', 'User', 'Freelance']);
            $table->string('profile_image')->nullable();
            $table->timestamp('last_seen')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::create('freelance', function (Blueprint $table) {
            $table->id();
            $table->longText('about');
            $table->string('foto_ktp');
            $table->string('selfie_ktp');
            $table->string('nik');
            $table->string('kode_pos');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('desa');
            $table->string('alamat');
            $table->enum('status', ['on', 'off'])->default('off');
            $table->string('portofolio')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('jenis_rekening')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('freelance');
    }
};
