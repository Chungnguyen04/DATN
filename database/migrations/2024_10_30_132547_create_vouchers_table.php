<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();                                        // Mã voucher
            $table->string('name');                                                  // Tên voucher
            $table->decimal('discount_value', 30, 0);                 // Giá trị giảm giá (Số tiền giảm)
            $table->decimal('discount_min_price', 30, 0)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->enum('discount_type', ['all', 'condition']);            // Loại discount: all: tất cả, condition: điều kiện giảm giá
            $table->dateTime('start_date');                              // Ngày bắt đầu áp dụng
            $table->dateTime('end_date');                                // Ngày hết hạn áp dụng
            $table->integer('total_uses')->default(0);                        // Số lần voucher có thể sử dụng
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
