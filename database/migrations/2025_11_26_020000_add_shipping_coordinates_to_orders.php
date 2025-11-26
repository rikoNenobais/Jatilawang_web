<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (! Schema::hasColumn('rentals', 'shipping_lat')) {
                $table->decimal('shipping_lat', 10, 7)->nullable()->after('shipping_address');
            }

            if (! Schema::hasColumn('rentals', 'shipping_lng')) {
                $table->decimal('shipping_lng', 10, 7)->nullable()->after('shipping_lat');
            }
        });

        Schema::table('buys', function (Blueprint $table) {
            if (! Schema::hasColumn('buys', 'shipping_lat')) {
                $table->decimal('shipping_lat', 10, 7)->nullable()->after('shipping_address');
            }

            if (! Schema::hasColumn('buys', 'shipping_lng')) {
                $table->decimal('shipping_lng', 10, 7)->nullable()->after('shipping_lat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            if (Schema::hasColumn('rentals', 'shipping_lng')) {
                $table->dropColumn('shipping_lng');
            }

            if (Schema::hasColumn('rentals', 'shipping_lat')) {
                $table->dropColumn('shipping_lat');
            }
        });

        Schema::table('buys', function (Blueprint $table) {
            if (Schema::hasColumn('buys', 'shipping_lng')) {
                $table->dropColumn('shipping_lng');
            }

            if (Schema::hasColumn('buys', 'shipping_lat')) {
                $table->dropColumn('shipping_lat');
            }
        });
    }
};
