<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LandingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        while ($i < 10) {
            $i++;
            DB::table('landings')->insert([
                'title' => str_random(15),
                'ratio' => random_int(0, 30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'buttons' => json_encode([
                    0 => [
                        'bg' => '#000000',
                        'title' => str_random(15),
                        'link' => 'http://' . kebab_case(str_random(15) . '.com')],
                    1 => [
                        'bg' => '#ffffff',
                        'title' => str_random(15),
                        'link' => 'http://' . kebab_case(str_random(15) . '.com')],
                ]),

            ]);
        }
    }
}
