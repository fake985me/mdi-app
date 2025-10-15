<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add user_id column to stock_movements if it doesn't exist
        if (!Schema::hasColumn('stock_movements', 'user_id')) {
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('total_amount');
            });
        }
        
        // Add user_id column to purchases if it doesn't exist
        if (!Schema::hasColumn('purchases', 'user_id')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }
        
        // Add user_id column to sales if it doesn't exist
        if (!Schema::hasColumn('sales', 'user_id')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }
        
        // Add user_id column to borrowings if it doesn't exist
        if (!Schema::hasColumn('borrowings', 'user_id')) {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('product_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
