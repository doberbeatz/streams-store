<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')
            ->insert([
                [
                    'id'        => 493057,
                    'name'      => 'PLAYERUNKNOWN\'S BATTLEGROUNDS',
                    'is_active' => true,
                ],
                [
                    'id'        => 29595,
                    'name'      => 'Dota 2',
                    'is_active' => true,
                ],
                [
                    'id'        => 32399,
                    'name'      => 'Counter-Strike: Global Offensive',
                    'is_active' => true,
                ],
                [
                    'id'        => 496712,
                    'name'      => 'Call of Duty: WWII',
                    'is_active' => true,
                ],
            ]);
    }
}
