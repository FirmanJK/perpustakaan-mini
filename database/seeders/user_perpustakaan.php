<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class user_perpustakaan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing users
        DB::table('users')->where('username', 'adminlib')->delete();
        DB::table('users')->where('username', 'guestlib')->delete();

        // Insert User Pustakawan
        DB::table('users')->insert([
            'username' => 'adminlib',
            'firstname' => 'Admin',
            'lastname' => 'Perpustakaan',
            'email' => 'adminlib@perpustakaan.com',
            'password' => Hash::make('MSJframework123!'),
            'idroles' => 'pustka',
            'image' => 'noimage.png',
            'isactive' => '1',
            'created_at' => now(),
            'updated_at' => now(),
            'user_create' => 'system'
        ]);

        // Insert User Pengunjung
        DB::table('users')->insert([
            'username' => 'guestlib',
            'firstname' => 'Guest',
            'lastname' => 'Pengunjung',
            'email' => 'guestlib@perpustakaan.com',
            'password' => Hash::make('MSJframework123!'),
            'idroles' => 'pngnjg',
            'image' => 'noimage.png',
            'isactive' => '1',
            'created_at' => now(),
            'updated_at' => now(),
            'user_create' => 'system'
        ]);
    }
}
