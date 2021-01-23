<?php

namespace Database\Seeders;

use App\Models\League;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leagues = json_decode(file_get_contents(resource_path('json/league_codes.json')));

        foreach ($leagues as $league) {
            if (! League::whereCode($league->code)->first()) {
                League::create((array)$league);
            }
        }
    }
}
