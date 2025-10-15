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
        // Update the products table to add the 'status' column if it doesn't exist
        if (!Schema::hasColumn('products', 'status')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('status')->default('active')->after('image_url');
            });
        }

        // Update the users table to ensure email is unique (skip if already exists)
        if (!Schema::hasIndex('users', 'users_email_unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('email');
            });
        }

        // Add soft deletes to the users table if it doesn't exist
        if (!Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Add brand table if it doesn't exist
        if (!Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // Add brand_id to products table if it doesn't exist
        if (!Schema::hasColumn('products', 'brand_id')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('brand_id')->nullable()->after('subcategory_id');
                $table->foreign('brand_id')->references('id')->on('brands');
            });
        }

        // Add suppliers table if it doesn't exist
        if (!Schema::hasTable('suppliers')) {
            Schema::create('suppliers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('contact_person')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Update purchases table to reference suppliers
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'supplier_id')) {
                $table->unsignedBigInteger('supplier_id')->nullable()->after('id');
                $table->foreign('supplier_id')->references('id')->on('suppliers');
                
                // Remove the supplier_name column since we now have a proper suppliers table
                if (Schema::hasColumn('purchases', 'supplier_name')) {
                    $table->dropColumn('supplier_name');
                }
                if (Schema::hasColumn('purchases', 'supplier_contact')) {
                    $table->dropColumn('supplier_contact');
                }
            }
        });

        // Add customers table if it doesn't exist
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('address')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Update sales table to reference customers
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('id');
                $table->foreign('customer_id')->references('id')->on('customers');
                
                // Remove customer_name and customer_contact from sales table
                if (Schema::hasColumn('sales', 'customer_name')) {
                    $table->dropColumn('customer_name');
                }
                if (Schema::hasColumn('sales', 'customer_contact')) {
                    $table->dropColumn('customer_contact');
                }
            }
        });

        // Update warranties table to reference customers
        Schema::table('warranties', function (Blueprint $table) {
            if (!Schema::hasColumn('warranties', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('product_id');
                $table->foreign('customer_id')->references('id')->on('customers');
                
                // Remove customer_name and customer_contact from warranties table
                if (Schema::hasColumn('warranties', 'customer_name')) {
                    $table->dropColumn('customer_name');
                }
                if (Schema::hasColumn('warranties', 'customer_contact')) {
                    $table->dropColumn('customer_contact');
                }
            }
        });

        // Update borrowings table to reference customers
        Schema::table('borrowings', function (Blueprint $table) {
            if (!Schema::hasColumn('borrowings', 'customer_id')) {
                $table->unsignedBigInteger('customer_id')->nullable()->after('product_id');
                $table->foreign('customer_id')->references('id')->on('customers');
                
                // Remove borrower_name and borrower_contact from borrowings table
                if (Schema::hasColumn('borrowings', 'borrower_name')) {
                    $table->dropColumn('borrower_name');
                }
                if (Schema::hasColumn('borrowings', 'borrower_contact')) {
                    $table->dropColumn('borrower_contact');
                }
            }
        });

        // Add specifications table for products
        if (!Schema::hasTable('product_specifications')) {
            Schema::create('product_specifications', function (Blueprint $table) {
                $table->id();
                $table->char('product_id', 36);
                $table->string('spec_name');
                $table->text('spec_value');
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }

        // Add product_images table for multiple product images
        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->char('product_id', 36);
                $table->string('image_path');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_primary')->default(false);
                $table->timestamps();
                
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add rollback logic for new tables and changes
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_specifications');

        // Remove foreign key and brand_id column from products before dropping brands table
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });

        // Now we can safely drop the brands table
        Schema::dropIfExists('brands');
        
        // Remove foreign key constraints for customers in other tables before dropping customers table
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'customer_id')) {
                $table->dropForeign(['customer_id']);
            }
        });

        Schema::table('warranties', function (Blueprint $table) {
            if (Schema::hasColumn('warranties', 'customer_id')) {
                $table->dropForeign(['customer_id']);
            }
        });

        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowings', 'customer_id')) {
                $table->dropForeign(['customer_id']);
            }
        });

        // Now we can drop the customers table
        Schema::dropIfExists('customers');

        // Remove foreign key constraints for suppliers before dropping suppliers table
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
            }
        });

        Schema::dropIfExists('suppliers');

        // Restore original columns in sales table
        Schema::table('sales', function (Blueprint $table) {
            if (Schema::hasColumn('sales', 'customer_id')) {
                $table->dropColumn('customer_id');
            }
            $table->string('customer_name')->nullable();
            $table->string('customer_contact')->nullable();
        });

        // Restore original columns in warranties table
        Schema::table('warranties', function (Blueprint $table) {
            if (Schema::hasColumn('warranties', 'customer_id')) {
                $table->dropColumn('customer_id');
            }
            $table->string('customer_name')->nullable();
            $table->string('customer_contact')->nullable();
        });

        // Restore original columns in borrowings table
        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowings', 'customer_id')) {
                $table->dropColumn('customer_id');
            }
            $table->string('borrower_name');
            $table->string('borrower_contact')->nullable();
        });

        // Restore original columns in purchases table
        Schema::table('purchases', function (Blueprint $table) {
            if (Schema::hasColumn('purchases', 'supplier_id')) {
                $table->dropColumn('supplier_id');
            }
            $table->string('supplier_name');
            $table->string('supplier_contact')->nullable();
        });
        
        // Remove soft deletes from users
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        // Remove status column from products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};