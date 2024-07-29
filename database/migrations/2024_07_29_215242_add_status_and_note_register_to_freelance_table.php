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
        Schema::table('freelance', function (Blueprint $table) {
            $table->enum('status_register', ['APPROVED', 'REJECTED', 'PENDING'])->default('PENDING')->after('alamat');
            $table->text('note_register')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('freelance', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('note_register');
        });
    }
};
