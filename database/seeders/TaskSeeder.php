<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create(['title' => 'Do that bug', 'task_user_id' => 1]);
        Task::create(['title' => 'Find Image', 'task_user_id' => 1]);
        Task::create(['title' => 'Fix height', 'task_user_id' => 1]);

        Task::create(['title' => 'View Camera', 'task_user_id' => 2]);
        Task::create(['title' => 'Find Image', 'task_user_id' => 2]);
        Task::create(['title' => 'dash fix', 'task_user_id' => 2]);
    }
}
