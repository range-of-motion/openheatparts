<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Heat pump manufacturers. Each name slugs to a distinct value.
     *
     * @var list<string>
     */
    private const NAMES = [
        'Aermec',
        'Airwell',
        'Alpha Innotec',
        'Ariston',
        'Atlantic',
        'Aux',
        'Baxi',
        'Bosch',
        'Bryant',
        'Buderus',
        'Carrier',
        'Chigo',
        'CIAT',
        'Clivet',
        'CTC',
        'Daikin',
        'De Dietrich',
        'Dimplex',
        'Elco',
        'Ferroli',
        'Fujitsu',
        'Glow-worm',
        'Goodman',
        'Grant',
        'Gree',
        'Haier',
        'Hautec',
        'Heliotherm',
        'Hisense',
        'Hitachi',
        'IDM',
        'Ideal Heating',
        'Intergas',
        'Inventum',
        'Itho Daalderop',
        'IVT',
        'Kensa',
        'Kronoterm',
        'Lennox',
        'LG',
        'MasterTherm',
        'Metro Therm',
        'Midea',
        'Mitsubishi Electric',
        'Mitsubishi Heavy Industries',
        'Nefit',
        'NIBE',
        'Nilan',
        'Novelan',
        'Ochsner',
        'Panasonic',
        'Phnix',
        'Quatt',
        'Qvantum',
        'Remeha',
        'Rheem',
        'Saunier Duval',
        'Samsung',
        'Sinclair',
        'Sprsun',
        'Stiebel Eltron',
        'Thermia',
        'Toshiba',
        'Trane',
        'Vaillant',
        'Viessmann',
        'Vølund',
        'Waterkotte',
        'Weishaupt',
        'Wolf',
        'Worcester Bosch',
        'York',
        'Zehnder',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(self::NAMES);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
