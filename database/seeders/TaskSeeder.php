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
    }
}
