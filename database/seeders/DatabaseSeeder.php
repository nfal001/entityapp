<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Database\Factories\UserInfoFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\UserStatus::factory()->createMany([['status'=>'pending'],['status'=>'active'],['status'=>'suspended']]);
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role'=> 'admin'
        ]);
        
        $users = \App\Models\User::factory()->createMany([[
            'name' => 'User customer',
            'email' => 'customer@example.com',
            'role'=> 'customer'
        ],[
            'name' => 'User customer To be deleted',
            'email' => 'deleteme@example.com',
            'role'=> 'customer'
        ]]);

        $users->each(function($user) {
            \App\Models\Features\UserInfo::factory()->createOne(['user_id'=>$user->id,'first_name'=>'Ste','last_name'=>'Van','phone'=>'08080808']);
        });
    }
}
