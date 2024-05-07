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
            $table->timestamps();
            $table->unsignedBigInteger('payer_id');
            $table->foreign('payer_id')->references('id')->on('users');
            $table->unsignedBigInteger('payee_id');
            $table->foreign('payee_id')->references('id')->on('users');
            $table->unsignedBigInteger('payer_wallet');
            $table->foreign('payer_wallet')->references('id')->on('wallets');
            $table->unsignedBigInteger('payee_wallet');
            $table->foreign('payee_wallet')->references('id')->on('wallets');
            $table->decimal('amount', 10, 2)->default(0.00);
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
