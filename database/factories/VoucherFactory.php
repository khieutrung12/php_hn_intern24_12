<?php

namespace Database\Factories;

// use Illuminate\Support\S
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->name() . time(),
            'name' => $this->faker->name(),
            'value' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'condition_min_price' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
            'maximum_reduction' => $this->faker->randomNumber($nbDigits = NULL, $strict = false),
        ];
    }
}
