<?php

use Illuminate\Database\Seeder;

use App\Offer;
use League\Csv\Reader;

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
        foreach ($results as $key => $row) {
        
            $offer = new Offer();
            $offer->ngo_id = 1;
            if(!empty($row[6]))
              $offer->street = $row[6];
            if(!empty($row[7]))
              $offer->streetnumber = $row[7];
            if(!empty($row[10]))
              $offer->zip = $row[10];
            if(!empty($row[11]))
              $offer->city = $row[11];
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
        }


    }
}
