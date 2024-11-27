<?php

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
            $table->bigInteger('user_id')->nullable();
            $table->string('code');
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->decimal('total_price', 30,0);

            $table->bigInteger('voucher_id')->nullable(); // Thêm trường này
            $table->decimal('discount_value', 30, 0)->default(0); // Thêm trường này
            $table->decimal('final_price', 30, 0)->default(0); // Thêm trường này

            // Trạng thái đơn hàng
            $table->enum('status', [
                'pending',         // Chờ xác nhận
                'confirmed',       // Đã xác nhận
                'shipping',        // Đang giao
                'delivering',      // Giao hàng thành công
                'failed',          // Giao hàng thất bại
                'cancelled',       // Đã hủy
                'completed'        // Hoàn thành
            ])->default('pending');

            $table->decimal('shipping_fee', 15,0)->default(0);
            // Hình thức thanh toán
            $table->enum('payment_method', ['cod', 'vnpay'])
                ->default('cod');
            //  cod: Thanh toán khi nhận,
            //  vnpay: Thanh toan vnpay,


            // Trạng thái thanh toán
            $table->enum('payment_status', ['unpaid', 'paid'])
                ->default('unpaid');
            //  unpaid: Đơn hàng chưa được thanh toán.
            //  paid: Đơn hàng đã được thanh toán thành công.

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
