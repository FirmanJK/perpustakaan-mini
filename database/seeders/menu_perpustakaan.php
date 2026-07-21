<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menu_perpustakaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing menu - auth dulu baru table & menu
        DB::table('sys_auth')->whereIn('dmenu', ['mstbkx', 'mstmbx', 'trslnx'])->delete();
        DB::table('sys_table')->whereIn('dmenu', ['mstbkx', 'mstmbx', 'trslnx'])->delete();
        DB::table('sys_dmenu')->where('dmenu', 'mstbkx')->delete();
        DB::table('sys_dmenu')->where('dmenu', 'mstmbx')->delete();
        DB::table('sys_dmenu')->where('dmenu', 'trslnx')->delete();

        // Insert Menu Master Buku
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '10',
            'name' => 'Master Buku',
            'icon' => 'ni-book-bookmark',
            'url' => 'mstbkx',
            'layout' => 'master',
            'tabel' => 'mst_books',
            'js' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Insert Menu Master Anggota
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstmbx',
            'urut' => '11',
            'name' => 'Master Anggota',
            'icon' => 'ni-badge',
            'url' => 'mstmbx',
            'layout' => 'master',
            'tabel' => 'mst_members',
            'js' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Insert Menu Transaksi Peminjaman (menggunakan controller khusus trslnx)
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '1',
            'name' => 'Peminjaman Buku',
            'icon' => 'ni-archive-2',
            'url' => 'trslnx',
            'layout' => 'trslnx',  // Menggunakan layout 'trslnx' agar menggunakan TrslnxController
            'tabel' => 'trs_loans',
            'js' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);
    }
}
