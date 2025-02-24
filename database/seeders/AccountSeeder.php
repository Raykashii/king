<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin'
            ],
            [
                'name' => 'Siswa User',
                'email' => 'siswa@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa'
            ],
            [
                'name' => 'Bank Mini User',
                'email' => 'bank_mini@example.com',
                'password' => Hash::make('password'),
                'role' => 'bank_mini'
            ],
        ]);
    }
}

