<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal', 10, 2)->after('status');
            $table->decimal('tax', 10, 2)->after('subtotal');
            $table->string('shipping_method')->after('tax');
            $table->string('payment_method')->after('shipping_method');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'tax', 'shipping_method', 'payment_method']);
        });
    }
};
