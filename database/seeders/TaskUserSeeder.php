<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\TaskUser;

class TaskUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaskUser::create([
            'name'  => 'Sahil Bhatia',
            'email' => 'sahil@sahil.com',
            'board_id' => 1,
        ]);

        TaskUser::create([
            'name'  => 'John Doe',
            'email' => 'john@doe.com',
            'board_id' => 1,
        ]);

        TaskUser::create([
            'name'  => 'Jane Doe',
            'email' => 'jane@doe.com',
            'board_id' => 2,
        ]);
    }
}
