<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use League\Csv\Reader;

class CategoryTableSeeder extends Seeder
{

    public function run()
    {

        $reader = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_german.csv');
        //$reader->setDelimiter("\t");
        $reader->setDelimiter(";");
        $results = $reader->fetch();

        $sortIndex = [0, 0, 0];
        foreach ($results as $key => $row) {
            if (!empty($row[0])) {
                $sortIndex[1] = $sortIndex[2] = 0;

                $parent = new Category;
                $parent->icon = "none";
                $parent->save();
                $parent->translateOrNew('de')->title = $row[0];
                $parent->translateOrNew('de')->description = $row[1];
                $parent->sortindex = $sortIndex[0];
                $parent->save();
                $sortIndex[0]++;

                if (!empty($row[2])) {
                    $sub1 = new Category;
                    $sub1->icon = "none";
                    $sub1->parent_id = $parent->id;
                    $sub1->sortindex = $sortIndex[1];
                    $sub1->save();
                    $sortIndex[1]++;
                    
                    $sub1->translateOrNew('de')->title = $row[2];
                    if (!empty($row[3])) {
                        $sub1->translateOrNew('de')->description = $row[3];
                    }
                    $sub1->save();
                    if (!empty($row[4])) {
                        $sub2 = new Category;
                        $sub2->icon = "none";
                        $sub2->parent_id = $sub1->id;
                        $sub1->sortindex = $sortIndex[2];
                        $sub2->save();
                        $sortIndex[2]++;
                        
                        $sub2->translateOrNew('de')->title = $row[4];
                        if (!empty($row[5])) {
                            $sub2->translateOrNew('de')->description = $row[5];
                        }
                        $sub2->save();
                    }
                }
            } elseif (!empty($row[2])) {
                $sub1 = new Category;
                $sub1->icon = "none";
                $sub1->parent_id = $parent->id;
                $sub1->sortindex = $sortIndex[1];
                $sub1->save();
                $sortIndex[1]++;

                $sub1->translateOrNew('de')->title = $row[2];
                if (!empty($row[3])) {
                    $sub1->translateOrNew('de')->description = $row[3];
                }
                $sub1->save();
            } elseif (!empty($row[4])) {
                $sub2 = new Category;
                $sub2->icon = "none";
                $sub2->parent_id = $sub1->id;
                $sub1->sortindex = $sortIndex[2];
                $sub2->save();
                $sortIndex[2]++;

                $sub2->translateOrNew('de')->title = $row[4];
                if (!empty($row[5])) {
                    $sub2->translateOrNew('de')->description = $row[5];
                }
                $sub2->save();
            }
        }
    }
}
