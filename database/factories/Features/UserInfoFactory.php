<?php

namespace Database\Factories\Features;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'=> fake()->firstName(),
            'last_name'=>fake()->lastName(),
            'phone'=>fake()->e164PhoneNumber() 
        ];
    }
}
