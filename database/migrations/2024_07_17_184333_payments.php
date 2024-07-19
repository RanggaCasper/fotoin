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
        Schema::create('payment_channel', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('desc');
            $table->string('image');
            $table->enum('is_qris',['on','off'])->default('off');
            $table->double('flat_fee')->default(0);
            $table->double('percent_fee')->default(0);
            $table->double('min_amount')->default(0);
            $table->double('max_amount')->default(0);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->longText('checkout_url')->nullable(); //PULSA, EMONEY
            $table->longText('nomor_va')->nullable(); // VIRTUAL AKUN
            $table->longText('qr_link')->nullable(); // QRIS
            $table->timestamp('expired_at')->useCurrent();
            $table->timestamp('paid_at')->nullable();
            $table->double('price');
            $table->double('fee');
            $table->double('total_price');
            $table->enum('status',['PAID','UNPAID','EXPIRED','FAILED']);
            $table->unsignedBigInteger('payment_channel_id');
            $table->foreign('payment_channel_id')->references('id')->on('payment_channel');
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
        Schema::dropIfExists('payment_channel');
        Schema::dropIfExists('payments');
    }
};
