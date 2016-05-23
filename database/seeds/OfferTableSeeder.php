<?php

use Illuminate\Database\Seeder;

use App\Offer;
use League\Csv\Reader;
use App\Ngo;
use App\Category;

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
        $categories = array();
        $street = "";
        $streetnumber = "";
        $zip = "";
        $city = "";

        foreach ($results as $key => $row) {

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
            if(!empty($row[1])){
              $categories = explode(',', $row[1]);
            }
            if(count($categories)){
              foreach($categories as $cat){
                $category = Category::whereTranslation('title', trim($cat))->first();
                $offer->categories()->attach($category);
              }
            }

        }


    }
}
