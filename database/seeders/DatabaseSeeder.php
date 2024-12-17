<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductsTableSeeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CapacitiesTableSeeder;
use Database\Seeders\ColorsTableSeeder;
use Database\Seeders\ProductVariantSeeder;
use Database\Seeders\VoucherSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\OrderItemSeeder;
use Database\Seeders\ConversationsTableSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // CategoriesTableSeeder::class,
            // CapacitiesTableSeeder::class,
            // ColorsTableSeeder::class,
            // ProductsTableSeeder::class,
            // UsersTableSeeder::class,
            // ProductVariantSeeder::class,
            // VoucherSeeder::class,
            // OrderSeeder::class,
            // OrderItemSeeder::class,
            // ConversationsTableSeeder::class,
            MessagesTableSeeder::class,
        ]);
    }
}
