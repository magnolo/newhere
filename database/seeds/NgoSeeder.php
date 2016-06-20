<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

use App\Ngo;
use App\User;

class NgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        $reader = Reader::createFromPath(base_path().'/database/seeds/csvs/ngos.csv');
        $reader->setDelimiter(";");
        $results = $reader->fetch();
        foreach ($results as $key => $row) {

            $ngo = new Ngo();
            $ngo->short = $row[0];
            $ngo->organisation = $row[1];
            $ngo->contact_email = $row[2];
            $ngo->website = $row[4];
            $ngo->contact = $row[5];
            $ngo->contact_phone = $row[6];
            $ngo->street = $row[7];
            $ngo->street_number = $row[8];
            $ngo->zip = $row[9];
            $ngo->city = $row[10];
            $ngo->published = true;
            $ngo->save();

            $ngo->translateOrNew('de')->description = $row[12];

            $ngo->save();

        }

        $ngo = new Ngo();
        $ngo->short = 'NONE';
        $ngo->organisation = '- No NGO -';
        $ngo->save();
    }
}
