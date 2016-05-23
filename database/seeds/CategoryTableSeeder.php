<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use League\Csv\Reader;

class CategoryTableSeeder extends Seeder
{


    public function run()
    {

        $german = Reader::createFromPath(base_path().'/database/seeds/csvs/categories_german.csv');
        $english = Reader::createFromPath(base_path().'/database/seeds/csvs/categories_english.csv');

        // Farsi translation not working cause of conflict in table data 50/51
        // $farsi = Reader::createFromPath(base_path().'/database/seeds/csvs/categories_farsi.csv');

        $german->setDelimiter(";");
        $english->setDelimiter(";");

        // Farsi translation not working cause of conflict in table data 50/51
        // $farsi->setDelimiter(";");

        $germanResults = $german->fetch();

        $parent = new Category;
        $sub1 = new Category;
        $sub2 = new Category;
        foreach ($germanResults as $key => $row) {
            $englishTrans = $english->fetchOne($key);

            // Farsi translation not working cause of conflict in table data 50/51
            // $farsiTrans = $farsi->fetchOne($key);

            if(!empty($row[0])){

              $parent = new Category;
              $parent->icon = "none";
              $parent->save();

              $parent->translateOrNew('de')->title = $row[0];
              $parent->translateOrNew('de')->description = $row[1];


              $parent->translateOrNew('en')->title = $englishTrans[0];
              $parent->translateOrNew('en')->description = $englishTrans[1];

              // Farsi translation not working cause of conflict in table data 50/51
              // $parent->translateOrNew('fa')->title = $farsiTrans[0];
              // $parent->translateOrNew('fa')->description = $farsiTrans[1];


              $parent->save();
              if(!empty($row[2])){
                $sub1 = new Category;
                $sub1->icon = "none";
                $sub1->parent_id = $parent->id;
                $sub1->save();

                $sub1->translateOrNew('de')->title = $row[2];
                $sub1->translateOrNew('de')->description = $row[3];

                $sub1->translateOrNew('en')->title = $englishTrans[2];
                $sub1->translateOrNew('en')->description = $englishTrans[3];

                // Farsi translation not working cause of conflict in table data 50/51
                // $sub1->translateOrNew('fa')->title = $farsiTrans[2];
                // $sub1->translateOrNew('fa')->description = $farsiTrans[3];

                $sub1->save();
                if(!empty($row[4])){
                  $sub2 = new Category;
                  $sub2->icon = "none";
                  $sub2->parent_id = $sub1->id;
                  $sub2->save();
                  $sub2->translateOrNew('de')->title = $row[4];
                  if(!empty($row[5])){
                      $sub2->translateOrNew('de')->description = $row[5];
                  }

                  $sub2->translateOrNew('en')->title = $englishTrans[4];
                  $sub2->translateOrNew('en')->description = $englishTrans[5];

                  // Farsi translation not working cause of conflict in table data 50/51
                  // $sub2->translateOrNew('fa')->title = $farsiTrans[4];
                  // $sub2->translateOrNew('fa')->description = $farsiTrans[5];

                  $sub2->save();
                }
              }
            }
            elseif(!empty($row[2])){
              $sub1 = new Category;
              $sub1->icon = "none";
              $sub1->parent_id = $parent->id;
              $sub1->save();
              $sub1->translateOrNew('de')->title = $row[2];
              if(!empty($row[3])){
                  $sub1->translateOrNew('de')->description = $row[3];
              }

              $sub1->translateOrNew('en')->title = $englishTrans[2];
              $sub1->translateOrNew('en')->description = $englishTrans[3];

              // Farsi translation not working cause of conflict in table data 50/51
              // $sub1->translateOrNew('fa')->title = $farsiTrans[2];
              // $sub1->translateOrNew('fa')->description = $farsiTrans[3];

              $sub1->save();
            }
            elseif(!empty($row[4])){
              $sub2 = new Category;
              $sub2->icon = "none";
              $sub2->parent_id = $sub1->id;
              $sub2->save();
              $sub2->translateOrNew('de')->title = $row[4];
              if(!empty($row[5])){
                  $sub2->translateOrNew('de')->description = $row[5];
              }

              $sub2->translateOrNew('en')->title = $englishTrans[4];
              $sub2->translateOrNew('en')->description = $englishTrans[5];

              // Farsi translation not working cause of conflict in table data 50/51
              // $sub2->translateOrNew('fa')->title = $farsiTrans[4];
              // $sub2->translateOrNew('fa')->description = $farsiTrans[5];

              $sub2->save();
            }
        }
    }
}
