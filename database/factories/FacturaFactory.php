<?php

namespace Database\Factories;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FacturaFactory extends Factory
{
    protected $model = Factura::class;

    public function definition()
    {
        return [
			'fecha_fac' => $this->faker->name,
			'num_fac' => $this->faker->name,
			'monto' => $this->faker->name,
			'proveedor_id' => $this->faker->name,
        ];
    }
}
