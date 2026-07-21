<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class tabel_mst_members extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_table')->where(['gmenu' => 'master', 'dmenu' => 'mstmbx'])->delete();

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstmbx',
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
            'dmenu' => 'mstmbx',
            'urut' => '2',
            'field' => 'nomor_anggota',
            'alias' => 'Nomor Anggota',
            'type' => 'string',
            'length' => '20',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:20|unique:mst_members,nomor_anggota',
            'primary' => '2',
            'filter' => '1',
            'list' => '1',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '3'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstmbx',
            'urut' => '3',
            'field' => 'nama_lengkap',
            'alias' => 'Nama Lengkap',
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
            'dmenu' => 'mstmbx',
            'urut' => '4',
            'field' => 'alamat',
            'alias' => 'Alamat',
            'type' => 'text',
            'length' => '500',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required',
            'primary' => '0',
            'filter' => '1',
            'list' => '0',
            'show' => '1',
            'query' => '',
            'class' => '',
            'position' => '4'
        ]);

        DB::table('sys_table')->insert([
            'gmenu' => 'master',
            'dmenu' => 'mstmbx',
            'urut' => '5',
            'field' => 'no_telp',
            'alias' => 'No. Telepon',
            'type' => 'string',
            'length' => '15',
            'decimals' => '0',
            'default' => '',
            'validate' => 'required|max:15',
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
            'dmenu' => 'mstmbx',
            'urut' => '6',
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
