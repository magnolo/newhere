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
        $ngo->website = "www.wwf.at";
        $ngo->contact = "WWF Chief";
        $ngo->contact_email ="wwf@ngo.at";
        $ngo->contact_phone = "01316546";

        $ngo->save();

        $user = User::where('email', "wwf@ngo.at")->firstOrFail();

        $ngo->users()->attach($user);

    }
}
