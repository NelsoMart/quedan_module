<?php

namespace Database\Factories;

use App\Models\Fuente;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FuenteFactory extends Factory
{
    protected $model = Fuente::class;

    public function definition()
    {
        return [
			'nombre_fuente' => $this->faker->name,
        ];
    }
}
