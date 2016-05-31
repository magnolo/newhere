<?php

use Illuminate\Database\Seeder;
use Illuminate\Console\Command;

use App\Offer;
use League\Csv\Reader;
use App\Ngo;
use App\Category;
use App\Filter;
use App\Logic\Address\AddressAPI;

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
        $wrongNgos = array();
        $addressApi = new AddressAPI();
        foreach ($results as $key => $row) {
            $categories = array();
            $filters = array();
            $ngo = Ngo::where('short', $row[0])->first();

            if(is_null($ngo)){
              $ngo = Ngo::where('short', 'NONE')->first();
                if(!in_array($row[0], $wrongNgos)){
                  $wrongNgos[] = $row[0];
                }
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

            $this->command->info($offer->street." ".$offer->streetnumber.", ". $offer->zip);
            if($offer->street != "" && $offer->streetnumber != "" && $offer->zip != ""){
              $coordinates = $addressApi->getCoordinates($offer->street, $offer->streetnumber, $offer->zip);
              $offer->latitude = $coordinates[0];
              $offer->longitude = $coordinates[1];
            }

            $offer->save();

            if(!empty($row[4])) $offer->translateOrNew('de')->title = $row[4];
            if(!empty($row[5])) $offer->translateOrNew('de')->description = $row[5];
            if(!empty($row[15])) $offer->translateOrNew('de')->opening_hours = $row[15];
            if(!empty($row[22])) $offer->translateOrNew('en')->title = $row[22];
            if(!empty($row[23])) $offer->translateOrNew('en')->description = $row[23];
            if(!empty($row[25])) $offer->translateOrNew('fa')->title = $row[25];
            if(!empty($row[26])) $offer->translateOrNew('fa')->description = $row[26];
            if(!empty($row[28])) $offer->translateOrNew('ar')->title = $row[28];
            if(!empty($row[29])) $offer->translateOrNew('ar')->description = $row[29];

            $offer->save();

            // Adding Categories
            if(!empty($row[1])){
              $categories = explode(',', $row[1]);
            }

            if(count($categories)){
              foreach($categories as $cat){
                $category = Category::where('slug', str_slug($cat,'-'))->first();
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

        //Console Output: Missing Ngos
        $this->command->info('Missing Ngos:');
        foreach ($wrongNgos as $key => $ngo) {
          $this->command->error($ngo);
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
