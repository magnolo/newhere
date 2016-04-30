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
                ['filterkey' => 'family', 'icon' => 'family', 'enabled' => true],
                ['filterkey' => 'men', 'icon' => 'men', 'enabled' => true],
                ['filterkey' => 'women', 'icon' => 'women', 'enabled' => true],
                ['filterkey' => 'children', 'icon' => 'child', 'enabled' => true],
                ['filterkey' => 'babies', 'icon' => 'baby', 'enabled' => true],
                ['filterkey' => 'limp', 'icon' => 'limp', 'enabled' => true],
                ['filterkey' => 'partially-blind', 'icon' => 'blind', 'enabled' => true],
                ['filterkey' => 'partially-deaf', 'icon' => 'deaf', 'enabled' => true],
                ['filterkey' => 'free', 'icon' => 'free', 'enabled' => true],
                ['filterkey' => 'queer', 'icon' => 'queer', 'enabled' => true],
                ['filterkey' => 'vegan', 'icon' => 'vegan', 'enabled' => true],
            ]
        );
    }
}
