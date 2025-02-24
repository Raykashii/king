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
            // Change user_id to reference accounts table
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade'); // accounts table            
            $table->enum('type', ['topup', 'withdraw', 'transfer']);
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed']);
            
            // Change recipient_id to reference accounts table (if required)
            $table->foreignId('recipient_id')->nullable()->constrained('accounts')->onDelete('set null'); // accounts table
            
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

