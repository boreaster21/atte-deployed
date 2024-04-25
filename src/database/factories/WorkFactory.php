<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Work;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Work::class;
    public function definition()
    {
        return [
            'user_id' => User::factory(),

            'start_at' => $this->faker->dateTimeBetween('-100weeks', 'now'),
            'finished_at' => $this->faker->dateTimeBetween('-100weekss', 'now'),
            'total_work' => $this->faker->numberBetween(3600, 36000),

            'start_rest' => $this->faker->dateTimeBetween('-100weeks', 'now'),
            'finished_rest' => $this->faker->dateTimeBetween('-100weeks', 'now'),
            'total_rest' => $this->faker->numberBetween(600, 5400),

            'work_on' => $this->faker->dateTimeBetween('-100weeks', 'now'),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
