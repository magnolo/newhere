<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = [
        //         ['parent_id' => null, 'icon' => 'star' , 'de' => ['title' => 'Lorem ipsum']],
        //         ['parent_id' => null, 'icon' => 'house' , 'de' => ['title' => 'Lorem ipsum']],
        //         ['parent_id' => null, 'icon' => 'doctor', 'de' => ['title' => 'Lorem ipsum']],
        //         ['parent_id' => 1, 'icon' => 'star1', 'de' => ['title' => 'Lorem ipsum']],
        //     ];
        //
        // Category::insert($data);

        $category = new Category();
        $category->icon = 'star';
        $category->save();

        $category->translateOrNew('de')->title = "Deutsch Parent";
        $category->translateOrNew('de')->description = "Testscription";
        $category->translateOrNew('en')->title = "English Parent";
        $category->translateOrNew('en')->description = "Testscription English";

        $category->save();

        $category2 = new Category();
        $category2->icon = 'house';
        $category2->parent_id = $category->id;
        $category2->save();

        $category2->translateOrNew('de')->title = "Deutsch Child";
        $category2->translateOrNew('de')->description = "Testscription";
        $category2->translateOrNew('en')->title = "English Child";
        $category2->translateOrNew('en')->description = "Testscription English";

        $category2->save();

        $category3 = new Category();
        $category3->icon = 'house';
        $category3->save();

        $category3->translateOrNew('de')->title = "Deutsch Next";
        $category3->translateOrNew('de')->description = "Testscription";

        $category3->save();



        /*DB::table('category_translations')->insert(
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
        );*/
    }
}
