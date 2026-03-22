<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Todo>
 */
class TodoFactory extends Factory
{
  public function definition(): array
  {
    return [
      'user_id'     => User::factory(),
      'title'       => fake()->sentence(4),
      'description' => fake()->optional()->paragraph(),
      'completed'   => false,
    ];
  }

  public function completed(): static
  {
    return $this->state(['completed' => true]);
  }
}
