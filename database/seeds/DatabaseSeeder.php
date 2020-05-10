<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(WeeksTableSeeder::class);
        $this->call(MatchesTableSeeder::class);
        $this->call(MatchesTeamsTableSeeder::class);
    }
}
