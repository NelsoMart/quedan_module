<?php

namespace Database\Factories;

use App\Models\Quedanfactura;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuedanfacturaFactory extends Factory
{
    protected $model = Quedanfactura::class;

    public function definition()
    {
        return [
			'factura_id' => $this->faker->name,
			'quedan_id' => $this->faker->name,
        ];
    }
}
