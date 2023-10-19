<?php

namespace Database\Factories;

//use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
//            'project_id' => Project::query()->inRandomOrder()->value('id'),
            'start_time' => $this->faker->dateTimeBetween('-20 week', '-10 week'),
            'finish_time' =>$this->faker->dateTimeBetween('-9 week', '-1 days')
        ];
    }
}
