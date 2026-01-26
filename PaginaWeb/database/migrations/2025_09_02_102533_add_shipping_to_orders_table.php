<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->default(0)->after('status');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('subtotal');
            $table->string('shipping_method')->nullable()->after('shipping_cost');
            $table->string('payment_method')->nullable()->after('shipping_method');
            $table->string('payment_status')->default('pendiente')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'subtotal',
                'shipping_cost',
                'shipping_method',
                'payment_method',
                'payment_status'
            ]);
        });
    }
};
