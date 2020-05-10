<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weeks')->insert(config('fake_data')['weeks']);
    }
}
