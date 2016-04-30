<?php

use Illuminate\Database\Seeder;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nh_filter')->insert(
            [
                ['filterkey' => 'family', 'icon' => 'family', 'disabled' => false],
                ['filterkey' => 'men', 'icon' => 'men', 'disabled' => false],
                ['filterkey' => 'women', 'icon' => 'women', 'disabled' => false],
                ['filterkey' => 'children', 'icon' => 'child', 'disabled' => false],
                ['filterkey' => 'babies', 'icon' => 'baby', 'disabled' => false],
                ['filterkey' => 'limp', 'icon' => 'limp', 'disabled' => false],
                ['filterkey' => 'partially-blind', 'icon' => 'blind', 'disabled' => false],
                ['filterkey' => 'partially-deaf', 'icon' => 'deaf', 'disabled' => false],
                ['filterkey' => 'free', 'icon' => 'free', 'disabled' => false],
                ['filterkey' => 'queer', 'icon' => 'queer', 'disabled' => false],
                ['filterkey' => 'vegan', 'icon' => 'vegan', 'disabled' => false],
            ]
        );
    }
}
