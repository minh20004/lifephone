<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'), // Mã hóa mật khẩu
                'role' => 'admin', // Ví dụ, role là 'admin'
                'avatar' => 'https://example.com/path/to/avatar1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'remember_token' => null, // Tạo lại token nếu cần
            ],
            [
                'name' => 'User One',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user', // Ví dụ, role là 'user'
                'avatar' => 'https://example.com/path/to/avatar2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'remember_token' => null,
            ],
            [
                'name' => 'User Two',
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'avatar' => 'https://example.com/path/to/avatar3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
                'remember_token' => null,
            ],
        ]);
    }
}
