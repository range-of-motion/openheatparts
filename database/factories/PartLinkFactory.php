<?php

namespace Database\Factories;

use App\Models\PartLink;
use App\Models\UnitPart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PartLink>
 */
class PartLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_part_id' => UnitPart::factory(),
            'user_id' => User::factory(),
            'url' => fake()->url(),
            'shop_name' => fake()->company(),
        ];
    }
}
