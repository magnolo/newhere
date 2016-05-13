<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use League\Csv\Reader;

class CategoryTableSeeder extends Seeder
{

    public function run()
    {

        $reader = Reader::createFromPath(base_path().'/database/seeds/csvs/categories_english.csv');
        $reader->setDelimiter("\t");
        $results = $reader->fetch();
        $parent = new Category;
        $sub1 = new Category;
        $sub2 = new Category;
        foreach ($results as $row) {
            if($row[0]){
              $parent = new Category;
              $parent->icon = "none";
              $parent->save();

              $parent->translateOrNew('de')->title = $row[0];
              $parent->translateOrNew('de')->description = $row[1];

              $parent->save();
              if(isset($row[2])){
                $sub1 = new Category;
                $sub1->icon = "none";
                $sub1->parent_id = $parent->id;
                $sub1->save();

                $sub1->translateOrNew('de')->title = $row[2];
                if(isset($row[3])){
                    $sub1->translateOrNew('de')->description = $row[3];
                }


                $sub1->save();
                if(isset($row[4])){
                  $sub2 = new Category;
                  $sub2->icon = "none";
                  $sub2->parent_id = $sub1->id;
                  $sub2->save();

                  $sub2->translateOrNew('de')->title = $row[4];
                  if(isset($row[5])){
                      $sub2->translateOrNew('de')->description = $row[5];
                  }

                  $sub2->save();
                }
              }
            }
            elseif(isset($row[2])){
              $sub1 = new Category;
              $sub1->icon = "none";
              $sub1->parent_id = $parent->id;
              $sub1->save();

              $sub1->translateOrNew('de')->title = $row[2];
              if(isset($row[3])){
                  $sub1->translateOrNew('de')->description = $row[3];
              }


              $sub1->save();
            }
            elseif(isset($row[4])){
              $sub2 = new Category;
              $sub2->icon = "none";
              $sub2->parent_id = $sub1->id;
              $sub2->save();

              $sub2->translateOrNew('de')->title = $row[4];
              if(isset($row[5])){
                  $sub2->translateOrNew('de')->description = $row[5];
              }

              $sub2->save();
            }


        }

        // $category = new Category();
        // $category->icon = 'star';
        // $category->save();
        //
        // $category->translateOrNew('de')->title = "Deutsch Parent";
        // $category->translateOrNew('de')->description = "Testscription";
        // $category->translateOrNew('en')->title = "English Parent";
        // $category->translateOrNew('en')->description = "Testscription English";
        //
        // $category->save();
        //
        // $category2 = new Category();
        // $category2->icon = 'house';
        // $category2->parent_id = $category->id;
        // $category2->save();
        //
        // $category2->translateOrNew('de')->title = "Deutsch Child";
        // $category2->translateOrNew('de')->description = "Testscription";
        // $category2->translateOrNew('en')->title = "English Child";
        // $category2->translateOrNew('en')->description = "Testscription English";
        //
        // $category2->save();
        //
        // $category3 = new Category();
        // $category3->icon = 'house';
        // $category3->save();
        //
        // $category3->translateOrNew('de')->title = "Deutsch Next";
        // $category3->translateOrNew('de')->description = "Testscription";
        //
        // $category3->save();
        //
        //
        //
        // /*DB::table('category_translations')->insert(
        //     [
        //         ['language_id' => 1, 'category_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //         ['language_id' => 2, 'category_id' => 1, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //
        //         ['language_id' => 1, 'category_id' => 2, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //         ['language_id' => 2, 'category_id' => 2, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //
        //         ['language_id' => 1, 'category_id' => 3, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //         ['language_id' => 2, 'category_id' => 3, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //
        //         ['language_id' => 1, 'category_id' => 4, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //         ['language_id' => 2, 'category_id' => 4, 'title' => 'Lorem ipsum', 'description' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. '],
        //     ]
        // );*/
    }
}
