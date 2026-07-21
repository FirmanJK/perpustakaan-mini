<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class role_perpustakaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing roles - auth dulu baru roles
        DB::table('sys_auth')->whereIn('idroles', ['pustka', 'pngnjg'])->delete();
        DB::table('sys_roles')->where('idroles', 'pustka')->delete();
        DB::table('sys_roles')->where('idroles', 'pngnjg')->delete();

        // Insert Role Pustakawan (Admin Perpustakaan)
        DB::table('sys_roles')->insert([
            'idroles' => 'pustka',
            'name' => 'Pustakawan',
            'description' => 'Admin Perpustakaan - Akses penuh mengelola buku, anggota, dan transaksi',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Insert Role Pengunjung (User Umum)
        DB::table('sys_roles')->insert([
            'idroles' => 'pngnjg',
            'name' => 'Pengunjung',
            'description' => 'User Umum - Hanya dapat melihat dashboard',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Delete existing auth
        DB::table('sys_auth')->where('idroles', 'pustka')->whereIn('dmenu', ['mstbkx', 'mstmbx', 'trslnx'])->delete();
        DB::table('sys_auth')->where('idroles', 'pngnjg')->whereIn('dmenu', ['mstbkx', 'mstmbx', 'trslnx'])->delete();

        // Insert Auth untuk Pustakawan (Full Access)
        // Dashboard Access
        DB::table('sys_auth')->insert([
            'gmenu' => 'blankx',
            'dmenu' => 'dashbr',
            'idroles' => 'pustka',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '0',
            'value' => '0',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Master Buku
        DB::table('sys_auth')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'idroles' => 'pustka',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Master Anggota
        DB::table('sys_auth')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstmbx',
            'idroles' => 'pustka',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Transaksi Peminjaman
        DB::table('sys_auth')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'idroles' => 'pustka',
            'add' => '1',
            'edit' => '1',
            'delete' => '1',
            'approval' => '1',
            'value' => '1',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Laporan Peminjaman - Hanya Pustakawan yang bisa akses
        DB::table('sys_auth')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rploan',
            'idroles' => 'pustka',
            'add' => '1',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '0',
            'print' => '1',
            'excel' => '1',
            'pdf' => '1',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Insert Auth untuk Pengunjung
        // Dashboard Access
        DB::table('sys_auth')->insert([
            'gmenu' => 'blankx',
            'dmenu' => 'dashbr',
            'idroles' => 'pngnjg',
            'add' => '0',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '0',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Master Buku - Read Only (Hanya bisa melihat daftar buku)
        DB::table('sys_auth')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'idroles' => 'pngnjg',
            'add' => '0',
            'edit' => '0',
            'delete' => '0',
            'approval' => '0',
            'value' => '0',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Transaksi Peminjaman - Create & Edit Only untuk Pengunjung
        DB::table('sys_auth')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'idroles' => 'pngnjg',
            'add' => '1',
            'edit' => '1',
            'delete' => '0',
            'approval' => '0',
            'value' => '0',
            'print' => '0',
            'excel' => '0',
            'pdf' => '0',
            'rules' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);
    }
}
