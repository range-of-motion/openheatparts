<?php

namespace Database\Factories;

use App\Enums\Confidence;
use App\Models\Part;
use App\Models\Unit;
use App\Models\UnitPart;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UnitPart>
 */
class UnitPartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::factory(),
            'part_id' => Part::factory(),
            'diagram_number' => fake()->unique()->numberBetween(1, 30000),
            'part_number' => null,
            'position_x' => null,
            'position_y' => null,
            'specs' => null,
            'confidence' => Confidence::Unverified,
        ];
    }
}
