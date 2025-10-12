<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class CheckTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:tables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if warehouse tables exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = [
            'categories',
            'subcategories', 
            'products',
            'profiles',
            'stock_movements',
            'purchases',
            'sales',
            'warranties',
            'borrowings'
        ];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                $this->info("✓ $table table exists");
            } else {
                $this->error("✗ $table table does not exist");
            }
        }
    }
}
