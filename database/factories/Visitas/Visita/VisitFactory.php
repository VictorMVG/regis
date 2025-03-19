<?php

namespace Database\Factories\Visitas\Visita;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitas\Visita\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1, // Siempre será el usuario con ID 1
            'headquarter_id' => $this->faker->numberBetween(1, 4),
            'visitor_name' => $this->faker->name(),
            'company_name' => $this->faker->company(),
            'reason' => $this->faker->sentence(),
            'to_see' => $this->faker->name(),
            'alcohol_test' => $this->faker->boolean(), // Valor booleano (1 o 0)
            'unit' => $this->faker->boolean(), // Valor booleano (1 o 0)
            'unit_plate' => $this->faker->bothify('???-###'),
            'unit_type_id' => $this->faker->numberBetween(1, 7),
            'unit_model' => $this->faker->word(),
            'unit_number' => $this->faker->numberBetween(1, 99),
            'unit_color_id' => $this->faker->numberBetween(1, 10),
            'comment' => $this->faker->sentence(),
            'exit_time' => $this->faker->optional()->dateTimeBetween('+1 hour', '+4 hours'),
        ];
    }
}
