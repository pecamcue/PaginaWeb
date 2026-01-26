<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentMethodsTableAddStripePaymentMethodId extends Migration
{
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('stripe_payment_method_id')->nullable()->after('expiry_date');
            $table->dropColumn('payment_token');
        });
    }

    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('stripe_payment_method_id');
            $table->string('payment_token')->nullable()->after('expiry_date');
        });
    }
}