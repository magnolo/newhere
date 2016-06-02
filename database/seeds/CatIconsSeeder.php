<?php

use Illuminate\Database\Seeder;

use App\Image;

class CatIconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $icons = array(
          '1464703160-Bildung',
          '1464703177-Gesundheit',
          '1464703203-Finanzen',
          '1464703215-Asyl',
          '1464703223-Arbeit',
          '1464703244-Community und Freizeit',
          '1464703252-Wohnen',
          '1464703260-Kommunikation',
          '1464703266-Essen',
          '1464703278-Alltagsgegenstände',
          '1464703285-Beratungsstellen'
        );

        foreach($icons as $i){
          $icon = new Image();
          $icon->src = "/uploads/images/".$i.".svg";
          $icon->basename = $i;
          $icon->dir = "uploads/images";
          $icon->filename = $i.".svg";
          $icon->save();
        }

    }
}
