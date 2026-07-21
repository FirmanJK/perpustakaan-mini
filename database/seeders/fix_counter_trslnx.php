<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class fix_counter_trslnx extends Seeder
{
    /**
     * Seeder untuk memperbaiki counter transaksi peminjaman buku
     * Menyelaraskan counter dengan data transaksi terakhir
     */
    public function run(): void
    {
        // Get last transaction number
        $lastTrans = DB::table('trs_loans')->orderBy('id', 'desc')->first();

        if ($lastTrans && $lastTrans->no_transaksi) {
            // Extract number from format TRXnnn (e.g., TRX010 -> 10)
            $lastNumber = (int) substr($lastTrans->no_transaksi, 3);
            
            // Check if counter record exists
            $counter = DB::table('sys_counter')->where('character', 'TRX-')->first();
            
            if ($counter) {
                // Update existing counter
                DB::table('sys_counter')
                    ->where('character', 'TRX-')
                    ->update([
                        'counter' => $lastNumber,
                        'lastid' => $lastTrans->no_transaksi
                    ]);
                
                echo "✓ Counter updated: " . $lastTrans->no_transaksi . " (counter: $lastNumber)\n";
                echo "  Next number will be: TRX" . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT) . "\n";
            } else {
                // Create new counter record
                DB::table('sys_counter')->insert([
                    'character' => 'TRX-',
                    'counter' => $lastNumber,
                    'lastid' => $lastTrans->no_transaksi
                ]);
                
                echo "✓ Counter created: " . $lastTrans->no_transaksi . " (counter: $lastNumber)\n";
            }
        } else {
            echo "ℹ No transactions found, counter initialization will happen on first insert\n";
        }
    }
}
