<?php

namespace Database\Factories;

use App\Models\Part;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Part>
 */
class PartFactory extends Factory
{
    /**
     * Generic heat pump parts. Each name slugs to a distinct value.
     *
     * @var list<string>
     */
    private const NAMES = [
        'Accumulator',
        'Actuator',
        'Ambient sensor',
        'Automatic air vent',
        'Backup heater',
        'Base pan',
        'Cable harness',
        'Capacitor',
        'Charge port',
        'Circulation pump',
        'Coil sensor',
        'Compressor',
        'Compressor mount',
        'Condensate pump',
        'Contactor',
        'Control board',
        'Crankcase heater',
        'Defrost heater',
        'Dirt separator',
        'Discharge sensor',
        'Display board',
        'Drain hose',
        'Drain pan',
        'Electrical box',
        'Electronic expansion valve',
        'Expansion valve',
        'Expansion vessel',
        'Fan',
        'Fan blade',
        'Fan grille',
        'Fan motor',
        'Filter drier',
        'Flexible hose',
        'Flow sensor',
        'Flow switch',
        'Four-way valve',
        'Front panel',
        'Fuse',
        'Gasket',
        'High pressure switch',
        'Indoor coil',
        'Indoor unit controller',
        'Insulation jacket',
        'Inverter board',
        'Liquid receiver',
        'Low pressure switch',
        'Magnetic filter',
        'Modbus gateway',
        'Muffler',
        'Oil separator',
        'O-ring',
        'Outdoor coil',
        'Outdoor sensor',
        'Outdoor unit controller',
        'Plate heat exchanger',
        'Pressure sensor',
        'Reactor',
        'Refrigerant oil',
        'Relay',
        'Remote control',
        'Reversing valve',
        'Room thermostat',
        'Safety valve',
        'Schrader valve',
        'Service valve',
        'Side panel',
        'Sight glass',
        'Sound jacket',
        'Strainer',
        'Suction sensor',
        'Terminal block',
        'Thermistor',
        'Three-way valve',
        'Top panel',
        'Transformer',
        'Two-way valve',
        'Vibration damper',
        'Water temperature sensor',
        'Wi-Fi module',
        'Zone valve',
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
