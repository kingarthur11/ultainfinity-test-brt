<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Userbrt;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Userbrt>
 */
class UserbrtFactory extends Factory
{
    protected $model = Userbrt::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Create a user if needed
            'brt_code' => $this->faker->unique()->word,
            'reserved_amount' => $this->faker->randomFloat(2, 0, 99999999.99),
            'status' => $this->faker->randomElement(['active', 'pending', 'expired']),
        ];
    }
    // /**
    //  * Define the model's default state.
    //  *
    //  * @return array<string, mixed>
    //  */
    // public function definition()
    // {
    //     return [
    //         //
    //     ];
    // }
}
