<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_trs_loans extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_table')->where(['gmenu' => 'transc', 'dmenu' => 'trslnx'])->delete();

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '1',
            'field' => 'id',
            'alias' => 'ID',
            'type' => 'number',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => '',
            'primary' => '0',  // Ubah dari 1 ke 0 - id bukan primary key untuk generate
            'filter' => '0',
            'list' => '0',
            'show' => '0',
            'query' => '',
            'class' => 'readonly',
            'position' => '0'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '2',
            'field' => 'no_transaksi',
            'alias' => 'No. Transaksi',
            'type' => 'string',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:20|unique:trs_loans,no_transaksi',
            'primary' => '1',  // Ubah dari 2 ke 1 - no_transaksi adalah primary key untuk generate
            'generateid' => 'no_transaksi',  // Tandai sebagai auto-generate
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '3',
            'field' => 'tgl_pinjam',
            'alias' => 'Tanggal Peminjaman',
            'type' => 'date',
            'length' => '10',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|date',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '4',
            'field' => 'tgl_kembali',
            'alias' => 'Tanggal Rencana Kembali',
            'type' => 'date',
            'length' => '10',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|date|after_or_equal:tgl_pinjam',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '5',
            'field' => 'tgl_dikembalikan',
            'alias' => 'Tanggal Aktual Kembali',
            'type' => 'date',
            'length' => '10',
            'decimals' => '0',
            'default' => '',
            'validate' => 'nullable|date',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '6',
            'field' => 'member_id',
            'alias' => 'Anggota',
            'type' => 'enum',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|exists:mst_members,id',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => "select id as value, concat(nomor_anggota, ' - ', nama_lengkap) as name from mst_members where isactive = '1'",
            'class' => 'select2',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '7',
            'field' => 'book_id',
            'alias' => 'Buku',
            'type' => 'enum',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|exists:mst_books,id',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => "select id as value, concat(judul, ' - ', penulis) as name from mst_books where isactive = '1' and stok > 0",
            'class' => 'select2',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '8',
            'field' => 'status',
            'alias' => 'Status',
            'type' => 'enum',
            'length' => '20',
            'decimals' => '0',
            'default' => 'Dipinjam',
            'validate' => 'required|in:Dipinjam,Dikembalikan',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => "select 'Dipinjam' as value, 'Dipinjam' as name union select 'Dikembalikan' as value, 'Dikembalikan' as name",
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '9',
            'field' => 'catatan',
            'alias' => 'Catatan',
            'type' => 'text',
            'length' => '500',
            'decimals' => '0',
            'default' => '',
            'validate' => 'nullable',
            'primary' => '0',
            'filter' => '1',
            'list' => '0',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'transc',
            'dmenu' => 'trslnx',
            'urut' => '10',
            'field' => 'isactive',
            'alias' => 'Status',
            'type' => 'enum',
            'length' => '1',
            'decimals' => '0',
            'default' => '1',
            'validate' => '',
            'primary' => '0',
            'filter' => '1',
            'list' => '0',
            'show' => '0',
            'query' => "select value, name from sys_enum where idenum = 'isactive' and isactive = '1'",
            'class' => '',
            'position' => '0'
        ]);
    }
}
