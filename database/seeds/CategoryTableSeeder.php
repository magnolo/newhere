<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Image;
use League\Csv\Reader;

class CategoryTableSeeder extends Seeder
{


    public function run()
    {
        $german = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_german.csv');
        $english = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_english.csv');
        $french = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_french.csv');
        $arabic = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_arabic.csv');
        $farsi = Reader::createFromPath(base_path() . '/database/seeds/csvs/categories_farsi.csv');

        $german->setDelimiter(";");
        $english->setDelimiter(";");
        $french->setDelimiter(";");
        $farsi->setDelimiter(";");
        $arabic->setDelimiter(";");


        $englishResults = $english->fetch();

        $parent = new Category;
        $sub1 = new Category;
        $sub2 = new Category;

        $sortIndex = [0, 0, 0];

        foreach ($englishResults as $key => $row) {
            $germanTrans = $german->fetchOne($key);

            // Farsi translation not working cause of conflict in table data 50/51
            $farsiTrans = $farsi->fetchOne($key);
            $frenchTrans = $french->fetchOne($key);
            $arabicTrans = $arabic->fetchOne($key);

            if (!empty($row[0])) {
                $sortIndex[1] = $sortIndex[2] = 0;
                $image = Image::where('basename', 'like', '%'.$germanTrans[0]."%" )->first();

                $parent = new Category;

                $parent->slug = str_slug($row[0]);

                if($image){
                  $parent->image_id = $image->id;
                }
                $parent->save();

                $parent->translateOrNew('en')->title = $row[0];
                $parent->translateOrNew('en')->description = $row[1];


                $parent->translateOrNew('de')->title = $germanTrans[0];
                $parent->translateOrNew('de')->description = $germanTrans[1];

                $parent->translateOrNew('fa')->title = $farsiTrans[0];
                $parent->translateOrNew('fa')->description = $farsiTrans[1];

                $parent->translateOrNew('fr')->title = $frenchTrans[0];
                $parent->translateOrNew('fr')->description = $frenchTrans[1];

                $parent->translateOrNew('ar')->title = $arabicTrans[0];
                $parent->translateOrNew('ar')->description = $arabicTrans[1];

                $parent->sortindex = $sortIndex[0];
                $sortIndex[0]++;

                $parent->save();

                if (!empty($row[2])) {
                    $sub1 = new Category;
                    //$sub1->icon = "none";
                    $sub1->parent_id = $parent->id;
                    $sub1->slug = str_slug($row[2]);
                    $sub1->sortindex = $sortIndex[1];
                    $sub1->save();

                    $sortIndex[1]++;

                    $sub1->translateOrNew('en')->title = $row[2];
                    $sub1->translateOrNew('en')->description = $row[3];

                    $sub1->translateOrNew('de')->title = $germanTrans[2];
                    $sub1->translateOrNew('de')->description = $germanTrans[3];

                    // Farsi translation not working cause of conflict in table data 50/51
                    $sub1->translateOrNew('fa')->title = $farsiTrans[2];
                    $sub1->translateOrNew('fa')->description = $farsiTrans[3];

                    $sub1->translateOrNew('fr')->title = $frenchTrans[2];
                    $sub1->translateOrNew('fr')->description = $frenchTrans[3];

                    $sub1->translateOrNew('ar')->title = $arabicTrans[2];
                    $sub1->translateOrNew('ar')->description = $arabicTrans[3];

                    $sub1->save();
                    if (!empty($row[4])) {
                        $sub2 = new Category;
                        //$sub2->icon = "none";
                        $sub2->parent_id = $sub1->id;
                        $sub2->slug = str_slug($row[4]);
                        $sub2->sortindex = $sortIndex[2];
                        $sub2->save();

                        $sortIndex[2]++;

                        $sub2->translateOrNew('en')->title = $row[4];
                        $sub2->translateOrNew('en')->description = $row[5];

                        $sub2->translateOrNew('de')->title = $germanTrans[4];
                        $sub2->translateOrNew('de')->description = $germanTrans[5];

                        // Farsi translation not working cause of conflict in table data 50/51
                        $sub2->translateOrNew('fa')->title = $farsiTrans[4];
                        $sub2->translateOrNew('fa')->description = $farsiTrans[5];

                        $sub2->translateOrNew('fr')->title = $frenchTrans[4];
                        $sub2->translateOrNew('fr')->description = $frenchTrans[5];

                        $sub2->translateOrNew('ar')->title = $arabicTrans[4];
                        $sub2->translateOrNew('ar')->description = $arabicTrans[5];

                        $sub2->save();
                    }
                }
            } elseif (!empty($row[2])) {
                $sub1 = new Category;
                $sub1->parent_id = $parent->id;
                $sub1->slug = str_slug($row[2]);
                $sub1->sortindex = $sortIndex[1];
                $sub1->save();

                $sortIndex[1]++;

                $sub1->translateOrNew('en')->title = $row[2];
                $sub1->translateOrNew('en')->description = $row[3];

                $sub1->translateOrNew('de')->title = $germanTrans[2];
                $sub1->translateOrNew('de')->description = $germanTrans[3];

                // Farsi translation not working cause of conflict in table data 50/51
                $sub1->translateOrNew('fa')->title = $farsiTrans[2];
                $sub1->translateOrNew('fa')->description = $farsiTrans[3];

                $sub1->translateOrNew('fr')->title = $frenchTrans[2];
                $sub1->translateOrNew('fr')->description = $frenchTrans[3];

                $sub1->translateOrNew('ar')->title = $arabicTrans[2];
                $sub1->translateOrNew('ar')->description = $arabicTrans[3];

                $sub1->save();

                if (!empty($row[4])) {
                    $sub2 = new Category;
                    //$sub2->icon = "none";
                    $sub2->parent_id = $sub1->id;
                    $sub2->slug = str_slug($row[4]);
                    $sub2->sortindex = $sortIndex[2];
                    $sub2->save();

                    $sortIndex[2]++;

                    $sub2->translateOrNew('en')->title = $row[4];
                    $sub2->translateOrNew('en')->description = $row[5];

                    $sub2->translateOrNew('de')->title = $germanTrans[4];
                    $sub2->translateOrNew('de')->description = $germanTrans[5];

                    // Farsi translation not working cause of conflict in table data 50/51
                    $sub2->translateOrNew('fa')->title = $farsiTrans[4];
                    $sub2->translateOrNew('fa')->description = $farsiTrans[5];


                    $sub2->translateOrNew('fr')->title = $frenchTrans[4];
                    $sub2->translateOrNew('fr')->description = $frenchTrans[5];

                    $sub2->translateOrNew('ar')->title = $arabicTrans[4];
                    $sub2->translateOrNew('ar')->description = $arabicTrans[5];

                    $sub2->save();
                }
            } elseif (!empty($row[4])) {
                $sub2 = new Category;
                $sub2->parent_id = $sub1->id;
                $sub2->slug = str_slug($row[4]);
                $sub2->sortindex = $sortIndex[2];
                $sub2->save();

                $sortIndex[2]++;

                $sub2->translateOrNew('en')->title = $row[4];
                $sub2->translateOrNew('en')->description = $row[5];

                $sub2->translateOrNew('de')->title = $germanTrans[4];
                $sub2->translateOrNew('de')->description = $germanTrans[5];

                // Farsi translation not working cause of conflict in table data 50/51
                $sub2->translateOrNew('fa')->title = $farsiTrans[4];
                $sub2->translateOrNew('fa')->description = $farsiTrans[5];

                $sub2->translateOrNew('fr')->title = $frenchTrans[4];
                $sub2->translateOrNew('fr')->description = $frenchTrans[5];

                $sub2->translateOrNew('ar')->title = $arabicTrans[4];
                $sub2->translateOrNew('ar')->description = $arabicTrans[5];

                $sub2->save();
              }

        }
    }
}
