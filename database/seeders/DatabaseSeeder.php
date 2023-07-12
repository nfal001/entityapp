<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\UserStatus::factory()->createMany([
            ['status' => 'pending'],
            ['status' => 'active'],
            ['status' => 'suspended']
        ]);

        // \App\Models\User::factory(10)->create();

        // TransactionStatus
        DB::table('transaction_statuses')->insert([
            [
                'status' => 'Pending',
                'message' => 'Preparing Order'
            ],
            [
                'status' => 'Delivering',
                'message' => 'Delivering Your Order'
            ],
            [
                'status' => 'Delivered',
                'message' => 'Order Delivered'
            ],
        ]);

        // Create Geo
        \App\Models\Geo\Province::factory()->createMany([
            ['name' => 'Jawa Barat'],
            ['name' => 'Jawa Timur'],
            ['name' => 'DI Yogyakarta']
        ])
        ->each(function ($prov) {
            $prov->city()->createMany([
                ['name' => fake()->city()],
                ['name' => fake()->city()]
            ])->each(function ($ci) {
                $ci->districts()->createMany([
                    ['name' => fake()->firstName()],
                    ['name' => fake()->firstName()]
                ]);
            });
        });

        $users = \App\Models\User::factory()->createMany([[
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin'
        ], [
            'name' => 'User customer',
            'email' => 'customer@example.com',
            'role' => 'customer'
        ], [
            'name' => 'User customer To be deleted',
            'email' => 'deleteme@example.com',
            'role' => 'customer'
        ]]);

        $users->each(function ($user) {
            \App\Models\Features\UserInfo::factory()->createOne([
                'user_id' => $user->id,
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'phone' => fake()->phoneNumber()
            ]);
        });

    }
}
