<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
                'password' => bcrypt('password123'), // Mã hóa mật khẩu
                'remember_token' => Str::random(10), // Token cho remember me
                'role' => 'admin', // Giá trị hợp lệ trong ENUM: 'admin'
                'avatar' => 'https://example.com/path/to/avatar1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(), // Đặt thời gian email đã được xác thực
            ],
            [
                'name' => 'Staff One',
                'email' => 'staff1@example.com',
                'password' => bcrypt('password123'),
                'remember_token' => Str::random(10),
                'role' => 'staff', // Giá trị hợp lệ trong ENUM: 'staff'
                'avatar' => 'https://example.com/path/to/avatar2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Customer One',
                'email' => 'customer1@example.com',
                'password' => bcrypt('password123'),
                'remember_token' => Str::random(10),
                'role' => 'customer', // Giá trị hợp lệ trong ENUM: 'customer'
                'avatar' => 'https://example.com/path/to/avatar3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Staff Two',
                'email' => 'staff2@example.com',
                'password' => bcrypt('password123'),
                'remember_token' => Str::random(10),
                'role' => 'staff',
                'avatar' => 'https://example.com/path/to/avatar4.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Customer Two',
                'email' => 'customer2@example.com',
                'password' => bcrypt('password123'),
                'remember_token' => Str::random(10),
                'role' => 'customer',
                'avatar' => 'https://example.com/path/to/avatar5.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin Two',
                'email' => 'admin2@example.com',
                'password' => bcrypt('password123'),
                'remember_token' => Str::random(10),
                'role' => 'admin',
                'avatar' => 'https://example.com/path/to/avatar6.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'email_verified_at' => Carbon::now(),
            ],
            // Thêm người dùng khác nếu cần
        ]);
    }
}
