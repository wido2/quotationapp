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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no')->unique();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->date('expiration');
            $table->longText('delivery_address')->nullable();
            $table->longText('invoice_address')->nullable();
            $table->date('reicived_date')->nullable();
            // $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('payment_term_id')->constrained('payment_terms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('grand_total',12,0);
            $table->longText('note')->nullable();
            $table->enum('status',[
                'draft','confirmed','canclled'
            ])->default('draft');
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
