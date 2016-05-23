<?php

use Illuminate\Database\Seeder;

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
        $ngo = new Ngo();

        $ngo->organisation = "WWF";
        $ngo->street = "World Wide";
        $ngo->street_number = "5";
        $ngo->zip = "1010";
        $ngo->city = "Wien";
        $ngo->website = "http://www.wwf.at";
        $ngo->contact = "WWF Chief";
        $ngo->contact_email ="wwf@ngo.at";
        $ngo->contact_phone = "+43 1 12345678";

        $ngo->save();

        $user = User::where('email', "wwf@ngo.at")->firstOrFail();

        $ngo->users()->attach($user);

        $ngo = new Ngo();

        $ngo->organisation = "Caritas";
        $ngo->street = "World Wide";
        $ngo->street_number = "5";
        $ngo->zip = "1010";
        $ngo->city = "Wien";
        $ngo->website = "http://www.caritas.at";
        $ngo->contact = "Caritas Chief";
        $ngo->contact_email ="caritas@ngo.at";
        $ngo->contact_phone = "+43 1 23456789";

        $ngo->save();

        $user = User::findOrFail(1);

        $ngo->users()->attach($user);

    }
}
