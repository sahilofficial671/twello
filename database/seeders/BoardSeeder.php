<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Board;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::create(['title' => 'Development', 'user_id' => 1]);
        Board::create(['title' => 'Development', 'user_id' => 2]);
    }
}
