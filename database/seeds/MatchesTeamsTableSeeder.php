<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\StaticAnalysis\HappyPath\AssertIsArray\consume;

class MatchesTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('match_team')->insert(config('fake_data')['match_team']);
    }
}
