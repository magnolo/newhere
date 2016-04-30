<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nh_category')->insert(
            [
                ['parent' => null, 'icon' => 'star'],
                ['parent' => null, 'icon' => 'house'],
                ['parent' => null, 'icon' => 'doctor'],
                ['parent' => 1, 'icon' => 'star1'],
            ]
        );

        DB::table('nh_category_translation')->insert(
            [
                ['language_id' => 1, 'category_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
                ['language_id' => 2, 'category_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],

                ['language_id' => 1, 'category_id' => 2, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
                ['language_id' => 2, 'category_id' => 2, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],

                ['language_id' => 1, 'category_id' => 3, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
                ['language_id' => 2, 'category_id' => 3, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],

                ['language_id' => 1, 'category_id' => 4, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
                ['language_id' => 2, 'category_id' => 4, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
            ]
        );
    }
}
