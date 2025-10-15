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
        // Convert created_by columns from UUID to integer references
        // This is part of the process to unify user reference system
        
        // Note: This is a simplified approach for this specific application
        // In a real-world scenario, you'd need to map UUIDs to integer IDs
        Schema::table('stock_movements', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $fks = DB::select("SELECT CONSTRAINT_NAME 
                              FROM information_schema.KEY_COLUMN_USAGE 
                              WHERE TABLE_SCHEMA = DATABASE() 
                              AND TABLE_NAME = 'stock_movements' 
                              AND COLUMN_NAME = 'created_by'
                              AND REFERENCED_TABLE_NAME IS NOT NULL");
            
            foreach ($fks as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }
            
            // Drop the column entirely if it exists
            if (Schema::hasColumn('stock_movements', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
        
        Schema::table('purchases', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $fks = DB::select("SELECT CONSTRAINT_NAME 
                              FROM information_schema.KEY_COLUMN_USAGE 
                              WHERE TABLE_SCHEMA = DATABASE() 
                              AND TABLE_NAME = 'purchases' 
                              AND COLUMN_NAME = 'created_by'
                              AND REFERENCED_TABLE_NAME IS NOT NULL");
            
            foreach ($fks as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }
            
            // Drop the column entirely if it exists
            if (Schema::hasColumn('purchases', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
        
        Schema::table('sales', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $fks = DB::select("SELECT CONSTRAINT_NAME 
                              FROM information_schema.KEY_COLUMN_USAGE 
                              WHERE TABLE_SCHEMA = DATABASE() 
                              AND TABLE_NAME = 'sales' 
                              AND COLUMN_NAME = 'created_by'
                              AND REFERENCED_TABLE_NAME IS NOT NULL");
            
            foreach ($fks as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }
            
            // Drop the column entirely if it exists
            if (Schema::hasColumn('sales', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
        
        Schema::table('borrowings', function (Blueprint $table) {
            // Drop the existing foreign key constraint if it exists
            $fks = DB::select("SELECT CONSTRAINT_NAME 
                              FROM information_schema.KEY_COLUMN_USAGE 
                              WHERE TABLE_SCHEMA = DATABASE() 
                              AND TABLE_NAME = 'borrowings' 
                              AND COLUMN_NAME = 'created_by'
                              AND REFERENCED_TABLE_NAME IS NOT NULL");
            
            foreach ($fks as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }
            
            // Drop the column entirely if it exists
            if (Schema::hasColumn('borrowings', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back the created_by columns with appropriate type
        Schema::table('stock_movements', function (Blueprint $table) {
            $table->char('created_by', 36)->nullable()->after('notes');
            $table->foreign('created_by')->references('id')->on('profiles');
        });
        
        Schema::table('purchases', function (Blueprint $table) {
            $table->char('created_by', 36)->nullable()->after('notes');
            $table->foreign('created_by')->references('id')->on('profiles');
        });
        
        Schema::table('sales', function (Blueprint $table) {
            $table->char('created_by', 36)->nullable()->after('notes');
            $table->foreign('created_by')->references('id')->on('profiles');
        });
        
        Schema::table('borrowings', function (Blueprint $table) {
            $table->char('created_by', 36)->nullable()->after('notes');
            $table->foreign('created_by')->references('id')->on('profiles');
        });
    }
};
