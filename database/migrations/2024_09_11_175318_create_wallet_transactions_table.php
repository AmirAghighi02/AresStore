<?php

use App\Enums\WalletTransactionStatus;
use App\Enums\WalletTransactionType;
use App\Models\Wallet;
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
        Schema::create('wallet_transactions', static function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->tinyInteger('status')->default(WalletTransactionStatus::INITIAL->value);
            $table->tinyInteger('type')->default(WalletTransactionType::WITHDRAW->value);
            $table->foreignIdFor(Wallet::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
