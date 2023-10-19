<?php

namespace Database\Seeders;

use Database\Factories\ProjectFactory;
use Database\Factories\TaskFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserFactory::new()->count(1)
            ->has(
                ProjectFactory::new()->count(20)
                    ->has(
                        TaskFactory::new()
                            ->count(rand(5, 15))
                    )
            )
            ->create();
    }
}
