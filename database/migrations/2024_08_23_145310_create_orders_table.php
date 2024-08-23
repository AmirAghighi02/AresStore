<?php

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\Payment;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('tax');
            $table->unsignedInteger('shipping_cost');
            $table->unsignedInteger('total_price');
            $table->enum('status', OrderStatus::values())->default(OrderStatus::PENDING->value);
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Payment::class)->constrained();
            $table->foreignIdFor(Address::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
