<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       \App\Models\User::create([
        'name' => 'Bartec',
        'email' => 'bahanbaku@gmail.com',
        'role' => 'Admin',
        'password' => Hash::make('bartec354')
        ]);
        \App\Models\User::create([
            'name' => 'Kepala Gudang',
            'email' => 'kepalagudang@gmail.com',
            'role' => 'Kepala Gudang',
            'password' => Hash::make('bartec354')
            ]);
        DB::table('golongans')->insert([
            ['id' => '1', 'name' => 'Bahan Baku - Plat'],
            ['id' => '2', 'name' => 'Bahan Baku - Stall'],
            ['id' => '3', 'name' => 'Bahan Baku - Pipa'],
            ['id' => '4', 'name' => 'Bahan Baku - AS'],
            ['id' => '5', 'name' => 'Bahan Baku - Logam Lainnya'],
            ['id' => '6', 'name' => 'Bahan Baku - Kayu'],
            ['id' => '7', 'name' => 'Bahan Baku - PC & Kimia'],
        ]);

        DB::table('jenis')->insert([
            ['id' => '1', 'name' => 'MS', 'golongan_id'=> '1'],
            ['id' => '2', 'name' => 'Galvanil', 'golongan_id'=> '1'],
            ['id' => '3', 'name' => 'SS', 'golongan_id'=> '1'],
            ['id' => '4', 'name' => 'Alumunium', 'golongan_id'=> '1'],
            ['id' => '5', 'name' => 'Plastik', 'golongan_id'=> '1'],
            ['id' => '6', 'name' => 'Nylon', 'golongan_id'=> '1'],
            ['id' => '7', 'name' => 'Kardus', 'golongan_id'=> '1'],
            ['id' => '8', 'name' => 'Karet', 'golongan_id'=> '1'],
            ['id' => '9', 'name' => 'Timah', 'golongan_id'=> '1'],
            ['id' => '10', 'name' => 'Gymsum', 'golongan_id'=> '1'],
            ['id' => '11', 'name' => 'Bordes', 'golongan_id'=> '1'],
            ['id' => '12', 'name' => 'Profil', 'golongan_id'=> '2'],
            ['id' => '13', 'name' => 'PVC', 'golongan_id'=> '2'],
            ['id' => '14', 'name' => 'Galvanis', 'golongan_id'=> '3'],
            ['id' => '15', 'name' => 'Tembaga', 'golongan_id'=> '3'],
            ['id' => '16', 'name' => 'Lain-lain', 'golongan_id'=> '4'],
            ['id' => '17', 'name' => 'Multiplek', 'golongan_id'=> '6'],
            ['id' => '18', 'name' => 'Vinyl', 'golongan_id'=> '6'],
            ['id' => '19', 'name' => 'HPL', 'golongan_id'=> '6'],
            ['id' => '20', 'name' => 'Liquid', 'golongan_id'=> '7'],
            ['id' => '21', 'name' => 'Powder', 'golongan_id'=> '7'],
            ['id' => '22', 'name' => 'Fiber', 'golongan_id'=> '7'],
            ['id' => '23', 'name' => 'Foam', 'golongan_id'=> '7'],
            ['id' => '24', 'name' => 'Plastik & Polimer Lain', 'golongan_id'=> '7'],
        ]);
}
}