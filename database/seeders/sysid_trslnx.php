<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class sysid_trslnx extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing sys_id for trslnx
        DB::table('sys_id')->where('dmenu', 'trslnx')->delete();

        // Insert sys_id configuration for auto-generate nomor transaksi
        // Format: TRX + counter 3 digit
        // Example: TRX001, TRX002, dst
        
        // Step 1: Add "TRX" prefix
        DB::table('sys_id')->insert([
            'dmenu' => 'trslnx',
            'source' => 'ext',      // external = static text
            'internal' => '-',
            'external' => 'TRX',    // prefix "TRX"
            'urut' => '1',
            'length' => '3',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);
        
        // Step 2: Add 3 digit counter
        DB::table('sys_id')->insert([
            'dmenu' => 'trslnx',
            'source' => 'cnt',      // counter
            'internal' => '-',
            'external' => '0',
            'urut' => '2',
            'length' => '3',        // 3 digit (001, 002, dst)
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);
    }
}
