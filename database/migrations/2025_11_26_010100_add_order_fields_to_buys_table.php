<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buys', function (Blueprint $table) {
            if (! Schema::hasColumn('buys', 'order_status')) {
                $table->enum('order_status', [
                    'menunggu_verifikasi',
                    'dikonfirmasi',
                    'diproses',
                    'dikirim',
                    'selesai',
                    'dibatalkan',
                ])->default('menunggu_verifikasi')->after('shipping_address');
            }

            if (! Schema::hasColumn('buys', 'delivery_option')) {
                $table->enum('delivery_option', ['pickup', 'delivery'])
                    ->default('pickup')
                    ->after('order_status');
            }

            if (! Schema::hasColumn('buys', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('delivery_option');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buys', function (Blueprint $table) {
            if (Schema::hasColumn('buys', 'shipped_at')) {
                $table->dropColumn('shipped_at');
            }

            if (Schema::hasColumn('buys', 'delivery_option')) {
                $table->dropColumn('delivery_option');
            }

            if (Schema::hasColumn('buys', 'order_status')) {
                $table->dropColumn('order_status');
            }
        });
    }
};
