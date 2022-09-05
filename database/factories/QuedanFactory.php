<?php

namespace Database\Factories;

use App\Models\Quedan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuedanFactory extends Factory
{
    protected $model = Quedan::class;

    public function definition()
    {
        return [
			'num_quedan' => $this->faker->name,
			'fecha_emi' => $this->faker->name,
			'cant_num' => $this->faker->name,
			'cant_letra' => $this->faker->name,
			'fuente_id' => $this->faker->name,
			'proyecto_id' => $this->faker->name,
        ];
    }
}
