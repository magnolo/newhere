<?php

use Illuminate\Database\Seeder;
use App\Image;

class FilterIconsSeeder extends Seeder
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
          '1464870455-Barrierefrei',
          '1464870698-Gratis',
          '1464870705-LGBTQI',
          '1464870716-Familie',
          '1464870725-Frauen',
          '1464870734-Maenner',
          '1464870762-Sehbehindert',
          '1464870766-Alte_Menschen',
          '1464870774-Hoergeschaedigt',
          '1464870780-Barrierefrei'
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
