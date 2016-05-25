<?php

use Illuminate\Database\Seeder;
use Illuminate\Console\Command;

use App\Offer;
use League\Csv\Reader;
use App\Ngo;
use App\Category;
use App\Filter;

class OfferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $reader = Reader::createFromPath(base_path().'/database/seeds/csvs/offers.csv');
        $reader->setDelimiter(";");
        $results = $reader->fetch();

        $street = "";
        $streetnumber = "";
        $zip = "";
        $city = "";


        $wrongCats = array();
        $wrongFilters = array();

        foreach ($results as $key => $row) {
            $categories = array();
            $filters = array();
            $ngo = Ngo::where('short', $row[0])->first();

            if(is_null($ngo)){
              $ngo = Ngo::where('short', 'NONE')->first();
            }

            $offer = new Offer();
            $offer->ngo_id = $ngo->id;
            if(!empty($row[6]))
              $street = $row[6];
            $offer->street = $street;

            if(!empty($row[7]))
              $streetnumber = $row[7];
            $offer->streetnumber = $streetnumber;

            if(!empty($row[10]))
              $zip = $row[10];
            $offer->zip = $zip;

            if(!empty($row[11]))
              $city = $row[11];
            $offer->city = $city;

            if(!empty($row[19]))
              $offer->phone = $row[19];
            if(!empty($row[17]))
              $offer->email = $row[17];
            if(!empty($row[18]))
              $offer->website = $row[18];

            $offer->save();

            if(!empty($row[4]) && !empty($row[5])){
              $offer->translateOrNew('de')->title = $row[4];
              $offer->translateOrNew('de')->description = $row[5];
                $offer->save();
            }
            if(!empty($row[22]) && !empty($row[23])){
              $offer->translateOrNew('en')->title = $row[22];
              $offer->translateOrNew('en')->description = $row[23];
                $offer->save();
            }

            // Adding Categories
            if(!empty($row[1])){
              $categories = explode(',', $row[1]);
            }

            if(count($categories)){
              foreach($categories as $cat){
                $category = Category::whereTranslation('title', trim($cat))->first();
                 if(!$category){
                    if(!in_array(trim($cat), $wrongCats)){
                      $wrongCats[] = trim($cat);
                    }
                }
                $offer->categories()->attach($category);
              }
            }

            // Adding Filters
            if(!empty($row[3])){
              $filters = explode(',', $row[3]);
            }

            if(count($filters)){
              foreach($filters as $f){
                $filter = Filter::whereTranslation('title', trim($f))->first();
                 if(!$filter){
                    if(!in_array(trim($f), $wrongFilters)){
                      $wrongFilters[] = trim($f);
                    }
                }
                $offer->filters()->attach($filter);
              }
            }

        }

        //Console Output: Missing Categories
        $this->command->info('Missing Categories:');
        foreach ($wrongCats as $key => $cat) {
          $this->command->error($cat);
        }

        //Console Output: Missing Filters
        $this->command->info('Missing Filters:');
        foreach ($wrongFilters as $key => $filter) {
          $this->command->error($filter);
        }

    }
}
