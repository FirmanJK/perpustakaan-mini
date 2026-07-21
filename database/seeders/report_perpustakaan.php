<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class report_perpustakaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing report menu - auth dulu baru menu & table
        DB::table('sys_auth')->where('dmenu', 'rploan')->delete();
        DB::table('sys_table')->where('dmenu', 'rploan')->delete();
        DB::table('sys_dmenu')->where('dmenu', 'rploan')->delete();

        // Insert Menu Laporan Peminjaman
        DB::table('sys_dmenu')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rploan',
            'urut' => '10',
            'name' => 'Laporan Peminjaman',
            'icon' => 'ni-single-copy-04',
            'url' => 'rploan',
            'layout' => 'report',
            'tabel' => 'trs_loans',
            'js' => '0',
            'isactive' => '1',
            'created_at' => now(),
            'user_create' => 'system'
        ]);

        // Konfigurasi sys_table untuk laporan
        // Field query (wajib untuk report layout)
        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rploan',
            'urut' => '0',
            'field' => 'query',
            'alias' => null,
            'type' => 'rploan',
            'length' => '0',
            'decimals' => '0',
            'default' => '',
            'validate' => '',
            'primary' => '0',
            'filter' => '0',
            'list' => '1',
            'show' => '1',
            'query' => "SELECT 
                t.no_transaksi,
                m.nomor_anggota,
                m.nama_lengkap,
                b.judul,
                b.penulis,
                t.tgl_pinjam,
                t.tgl_kembali,
                t.tgl_dikembalikan,
                t.status,
                t.catatan
            FROM trs_loans t
            LEFT JOIN mst_members m ON t.member_id = m.id
            LEFT JOIN mst_books b ON t.book_id = b.id
            WHERE (t.status LIKE :status)
            AND (t.tgl_pinjam BETWEEN :frtgl_pinjam AND :totgl_pinjam)
            AND t.isactive = '1'
            ORDER BY t.tgl_pinjam DESC",
            'class' => ''
        ]);
        
        // Field untuk filter
        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rploan',
            'urut' => '1',
            'field' => 'status',
            'alias' => 'Status',
            'type' => 'enum',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => '',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => "select '' as value, 'Semua' as name union select 'Dipinjam' as value, 'Dipinjam' as name union select 'Dikembalikan' as value, 'Dikembalikan' as name",
            'class' => ''
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'report',
            'dmenu' => 'rploan',
            'urut' => '2',
            'field' => 'tgl_pinjam',
            'alias' => 'Periode',
            'type' => 'date2',
            'length' => '10',
            'decimals' => '0',
            'default' => '',
            'validate' => '',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => ''
        ]);
    }
}
