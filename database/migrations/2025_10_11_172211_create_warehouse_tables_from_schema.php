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
        // Create profiles table if it doesn't exist
        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('user_id', 36)->nullable();
                $table->string('email')->unique();
                $table->string('full_name');
                $table->enum('role', ['superadmin', 'admin', 'user'])->default('user');
                $table->timestamps();
                
                // Don't add foreign key constraint as users.id is integer while user_id is char(36)
                // This is intentional to allow flexibility between different user implementations
            });
        }

        // Create categories table if it doesn't exist
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Create subcategories table if it doesn't exist
        if (!Schema::hasTable('subcategories')) {
            Schema::create('subcategories', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('category_id', 36)->nullable();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
                
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }

        // Create products table if it doesn't exist
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('sku')->unique();
                $table->char('category_id', 36)->nullable();
                $table->char('subcategory_id', 36)->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('cost_price', 10, 2)->default(0);
                $table->integer('current_stock')->default(0);
                $table->integer('minimum_stock')->default(0);
                $table->integer('maximum_stock')->default(0);
                $table->text('image_url')->nullable();
                $table->timestamps();

                $table->foreign('category_id')->references('id')->on('categories');
                $table->foreign('subcategory_id')->references('id')->on('subcategories');
            });
            
            // Create indexes for better performance
            Schema::table('products', function (Blueprint $table) {
                $table->index('category_id');
                $table->index('subcategory_id');
                $table->index('sku');
            });
        }

        // Create stock_movements table if it doesn't exist
        if (!Schema::hasTable('stock_movements')) {
            Schema::create('stock_movements', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('product_id', 36);
                $table->enum('movement_type', ['incoming', 'outgoing', 'purchase', 'sale', 'borrow', 'return']);
                $table->integer('quantity');
                $table->decimal('unit_price', 10, 2)->nullable();
                $table->decimal('total_amount', 10, 2)->nullable();
                $table->text('notes')->nullable();
                $table->char('created_by', 36)->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('profiles');
            });
            
            // Create indexes for better performance
            Schema::table('stock_movements', function (Blueprint $table) {
                $table->index('product_id');
                $table->index('movement_type');
                $table->index('created_at');
            });
        }

        // Create purchases table if it doesn't exist
        if (!Schema::hasTable('purchases')) {
            Schema::create('purchases', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->string('supplier_name');
                $table->string('supplier_contact')->nullable();
                $table->timestamp('purchase_date')->useCurrent();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->text('notes')->nullable();
                $table->char('created_by', 36)->nullable();
                $table->timestamps();

                $table->foreign('created_by')->references('id')->on('profiles');
            });
        }

        // Create sales table if it doesn't exist
        if (!Schema::hasTable('sales')) {
            Schema::create('sales', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->string('customer_name')->nullable();
                $table->string('customer_contact')->nullable();
                $table->timestamp('sale_date')->useCurrent();
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->text('notes')->nullable();
                $table->char('created_by', 36)->nullable();
                $table->timestamps();

                $table->foreign('created_by')->references('id')->on('profiles');
            });
            
            // Create indexes for better performance
            Schema::table('sales', function (Blueprint $table) {
                $table->index('sale_date');
            });
        }

        // Create warranties table if it doesn't exist
        if (!Schema::hasTable('warranties')) {
            Schema::create('warranties', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('product_id', 36);
                $table->timestamp('warranty_start_date')->useCurrent();
                $table->timestamp('warranty_end_date');
                $table->text('warranty_terms')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_contact')->nullable();
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }

        // Create borrowings table if it doesn't exist
        if (!Schema::hasTable('borrowings')) {
            Schema::create('borrowings', function (Blueprint $table) {
                $table->char('id', 36)->primary();
                $table->char('product_id', 36);
                $table->string('borrower_name');
                $table->string('borrower_contact')->nullable();
                $table->integer('quantity');
                $table->timestamp('borrow_date')->useCurrent();
                $table->timestamp('expected_return_date');
                $table->timestamp('actual_return_date')->nullable();
                $table->enum('status', ['active', 'returned', 'overdue'])->default('active');
                $table->text('notes')->nullable();
                $table->char('created_by', 36)->nullable();
                $table->timestamps();

                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('profiles');
            });
            
            // Create indexes for better performance
            Schema::table('borrowings', function (Blueprint $table) {
                $table->index('status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('warranties');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('products');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('profiles');
    }
};
