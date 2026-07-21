<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_mst_books extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_table')->where(['gmenu' => 'master', 'dmenu' => 'mstbkx'])->delete();

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '1',
            'field' => 'id',
            'alias' => 'ID',
            'type' => 'number',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => '',
            'primary' => '1',
            'filter' => '0',
            'list' => '0',
            'show' => '0',
            'query' => '',
            'class' => 'readonly',
            'position' => '0'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '2',
            'field' => 'judul',
            'alias' => 'Judul Buku',
            'type' => 'string',
            'length' => '255',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:255|min:1',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '3',
            'field' => 'penulis',
            'alias' => 'Nama Penulis',
            'type' => 'string',
            'length' => '100',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:100|min:1',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '4',
            'field' => 'penerbit',
            'alias' => 'Nama Penerbit',
            'type' => 'string',
            'length' => '100',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:100|min:1',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '5',
            'field' => 'tahun',
            'alias' => 'Tahun Terbit',
            'type' => 'number',
            'length' => '9999',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|numeric|digits:4',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '6',
            'field' => 'stok',
            'alias' => 'Jumlah Stok Buku',
            'type' => 'number',
            'length' => '10',
            'decimals' => '0',
            'default' => '0',
            'validate' => 'required|numeric|min:0',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstbkx',
            'urut' => '7',
            'field' => 'isactive',
            'alias' => 'Status',
            'type' => 'enum',
            'length' => '1',
            'decimals' => '0',
            'default' => '1',
            'validate' => '',
            'primary' => '0',
            'filter' => '1',
            'list' => '1',
            'show' => '0',
            'query' => "select value, name from sys_enum where idenum = 'isactive' and isactive = '1'",
            'class' => '',
            'position' => '0'
        ]);
    }
}
