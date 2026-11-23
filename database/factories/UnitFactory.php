<?php

namespace Database\Factories;

use App\Enums\UnitType;
use App\Models\Brand;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = 'Unit '.fake()->unique()->numerify('#####');

        return [
            'brand_id' => Brand::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'type' => UnitType::Outdoor,
            'diagram_path' => null,
        ];
    }
}
