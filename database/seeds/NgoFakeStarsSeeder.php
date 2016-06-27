<?php

use Illuminate\Database\Seeder;


use App\Ngo;

class NgoFakeStarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ngos = Ngo::where('id','<=', 237)->get();

        foreach($ngos as $ngo){
          $ngo->organisation = $ngo->organisation."***";
          $ngo->save();
        }
    }
}
