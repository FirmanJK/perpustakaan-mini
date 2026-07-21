<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class data_perpustakaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing data - gunakan delete, bukan truncate karena ada foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('trs_loans')->truncate();
        DB::table('mst_books')->truncate();
        DB::table('mst_members')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insert Data Buku
        DB::table('mst_books')->insert([
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => '2005',
                'stok' => 10,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'tahun' => '1980',
                'stok' => 8,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Sang Pemimpi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => '2006',
                'stok' => 12,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Ronggeng Dukuh Paruk',
                'penulis' => 'Ahmad Tohari',
                'penerbit' => 'Gramedia',
                'tahun' => '1982',
                'stok' => 5,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Perahu Kertas',
                'penulis' => 'Dee Lestari',
                'penerbit' => 'Bentang Pustaka',
                'tahun' => '2009',
                'stok' => 15,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'penerbit' => 'Gramedia',
                'tahun' => '2009',
                'stok' => 7,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Ayat-Ayat Cinta',
                'penulis' => 'Habiburrahman El Shirazy',
                'penerbit' => 'Republika',
                'tahun' => '2004',
                'stok' => 9,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Hujan',
                'penulis' => 'Tere Liye',
                'penerbit' => 'Gramedia',
                'tahun' => '2016',
                'stok' => 20,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Pulang',
                'penulis' => 'Leila S. Chudori',
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'tahun' => '2012',
                'stok' => 6,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'judul' => 'Cantik Itu Luka',
                'penulis' => 'Eka Kurniawan',
                'penerbit' => 'Gramedia',
                'tahun' => '2002',
                'stok' => 11,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ]
        ]);

        // Insert Data Anggota
        DB::table('mst_members')->insert([
            [
                'nomor_anggota' => 'MBR001',
                'nama_lengkap' => 'Budi Santoso',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'no_telp' => '081234567890',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR002',
                'nama_lengkap' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Sudirman No. 25, Jakarta Selatan',
                'no_telp' => '081298765432',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR003',
                'nama_lengkap' => 'Ahmad Fauzi',
                'alamat' => 'Jl. Gatot Subroto No. 88, Jakarta Barat',
                'no_telp' => '085612345678',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR004',
                'nama_lengkap' => 'Dewi Lestari',
                'alamat' => 'Jl. Thamrin No. 15, Jakarta Pusat',
                'no_telp' => '082187654321',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR005',
                'nama_lengkap' => 'Rudi Hermawan',
                'alamat' => 'Jl. Imam Bonjol No. 45, Jakarta Timur',
                'no_telp' => '087654321098',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR006',
                'nama_lengkap' => 'Rina Wati',
                'alamat' => 'Jl. Kebon Sirih No. 20, Jakarta Pusat',
                'no_telp' => '089876543210',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR007',
                'nama_lengkap' => 'Joko Widodo',
                'alamat' => 'Jl. Pahlawan No. 77, Jakarta Utara',
                'no_telp' => '081123456789',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'nomor_anggota' => 'MBR008',
                'nama_lengkap' => 'Sri Mulyani',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta Selatan',
                'no_telp' => '085298765432',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ]
        ]);

        // Insert Data Transaksi Peminjaman
        DB::table('trs_loans')->insert([
            [
                'no_transaksi' => 'TRX001',
                'tgl_pinjam' => '2025-01-10',
                'tgl_kembali' => '2025-01-17',
                'tgl_dikembalikan' => '2025-01-16',
                'member_id' => 1,
                'book_id' => 1,
                'status' => 'Dikembalikan',
                'catatan' => 'Buku dikembalikan dalam kondisi baik',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX002',
                'tgl_pinjam' => '2025-01-11',
                'tgl_kembali' => '2025-01-18',
                'tgl_dikembalikan' => null,
                'member_id' => 2,
                'book_id' => 3,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX003',
                'tgl_pinjam' => '2025-01-12',
                'tgl_kembali' => '2025-01-19',
                'tgl_dikembalikan' => null,
                'member_id' => 3,
                'book_id' => 5,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX004',
                'tgl_pinjam' => '2025-01-08',
                'tgl_kembali' => '2025-01-15',
                'tgl_dikembalikan' => '2025-01-15',
                'member_id' => 4,
                'book_id' => 2,
                'status' => 'Dikembalikan',
                'catatan' => 'Tepat waktu',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX005',
                'tgl_pinjam' => '2025-01-13',
                'tgl_kembali' => '2025-01-20',
                'tgl_dikembalikan' => null,
                'member_id' => 5,
                'book_id' => 7,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX006',
                'tgl_pinjam' => '2025-01-09',
                'tgl_kembali' => '2025-01-16',
                'tgl_dikembalikan' => '2025-01-18',
                'member_id' => 6,
                'book_id' => 4,
                'status' => 'Dikembalikan',
                'catatan' => 'Terlambat 2 hari',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX007',
                'tgl_pinjam' => '2025-01-14',
                'tgl_kembali' => '2025-01-21',
                'tgl_dikembalikan' => null,
                'member_id' => 7,
                'book_id' => 8,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX008',
                'tgl_pinjam' => '2025-01-07',
                'tgl_kembali' => '2025-01-14',
                'tgl_dikembalikan' => '2025-01-13',
                'member_id' => 8,
                'book_id' => 6,
                'status' => 'Dikembalikan',
                'catatan' => 'Dikembalikan lebih awal',
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX009',
                'tgl_pinjam' => '2025-01-15',
                'tgl_kembali' => '2025-01-22',
                'tgl_dikembalikan' => null,
                'member_id' => 1,
                'book_id' => 9,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ],
            [
                'no_transaksi' => 'TRX010',
                'tgl_pinjam' => '2025-01-14',
                'tgl_kembali' => '2025-01-21',
                'tgl_dikembalikan' => null,
                'member_id' => 2,
                'book_id' => 10,
                'status' => 'Dipinjam',
                'catatan' => null,
                'isactive' => '1',
                'created_at' => now(),
                'user_create' => 'system'
            ]
        ]);
    }
}
