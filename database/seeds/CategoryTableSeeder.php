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
    }
}
