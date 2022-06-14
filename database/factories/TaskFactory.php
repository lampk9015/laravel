<?php

namespace Database\Factories;

use App\Domains\Task\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * Class TaskFactory.
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => Str::title($this->faker->words(2, true)),
            'description' => $this->faker->sentence,
            'deadline_at' => $this->faker->dateTimeInInterval('now', '+ 15 days') ,
            'is_completed' => $this->faker->randomElement([1, 0]),
            'user_id' => 1,
        ];
    }
}
