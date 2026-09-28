<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'voc@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('00000000'),
                'role' => 'admin',
                'status' => 'dang_hoat_dong',
            ]
        );
    }
}
