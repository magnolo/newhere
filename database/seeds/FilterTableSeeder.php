<?php

use Illuminate\Database\Seeder;

use App\Filter;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected function createFilter($key, $f, $parent_id = null){
      $filter = new Filter();
      $filter->slug = $key;
      $filter->icon = $key;
      $filter->parent_id = $parent_id;
      $filter->type = isset($f['type']) ? $f['type'] : null;

      $filter->save();
      $filter->translateOrNew('de')->title = $f['de'];
      $filter->translateOrNew('en')->title = $f['en'];
      $filter->save();
      return $filter;
    }
    public function run()
    {

        $filters = [
          'family' => [
            'de' => 'Familie',
            'en' => 'Family',
            'type' => 'icon'
          ],
          'women' => [
            'de' => 'Frauen',
            'en' => 'Women',
            'type' => 'icon'
          ],
          'men' => [
            'de' => 'Männer',
            'en' => 'Men',
            'type' => 'icon'
          ],
          'age' => [
            'de' => 'Alter',
            'en' => 'Age',
            'type' => 'dropdown',
            'children' => [
              '0-5' => [
                'de' => '0-5 Jahre',
                'en' => '0-5 years'
              ],
              '5-10' => [
                'de' => '5-10 Jahre',
                'en' => '5-10 years'
              ],
              '11-17' => [
                'de' => '11-17 Jahre',
                'en' => '11-17 years'
              ],
              'under-27' => [
                'de' => 'unter 27',
                'en' => 'under 27'
              ],
              '27+' => [
                'de' => '27+',
                'en' => '27+'
              ]
            ]
          ],
          'persons-with-disabilities' => [
            'de' => 'Menschen mit besonderen Bedürfnissen',
            'en' => 'Persons with Disabilities',
            'type' => 'icon'
          ],
          'barrier-free' => [
            'de' => 'Barrierefrei',
            'en' => 'Barrier Free',
            'type' => 'icon'
          ],
          'culture-pass' => [
            'de' => 'Kulturpass',
            'en' => 'Culture Pass',
            'type' => 'icon'
          ],
          'free' => [
            'de' => 'Gratis',
            'en' => 'Free',
            'type' => 'icon'
          ],
          'country-of-origin' => [
            'de' => 'Herkunftsland',
            'en' => 'Country of Origin',
            'type' => 'dropdown',
            'children' => [
              'syria' => [
                'de' => 'Syrien',
                'en' => 'Syria'
              ],
              'afghanistan' => [
                'de' => 'Afghanistan',
                'en' => 'Afghanistan'
              ],
              'iraq' => [
                'de' => 'Irak',
                'en' => 'Iraq'
              ],
              'iran' => [
                'de' => 'Iran',
                'en' => 'Iran'
              ],
              'pakistan' => [
                'de' => 'Pakistan',
                'en' => 'Pakistan'
              ],
              'nigeria' => [
                'de' => 'Nigerien',
                'en' => 'Nigeria'
              ],
              'morocco' => [
                'de' => 'Marokko',
                'en' => 'Morocco'
              ],
              'algeria' => [
                'de' => 'Algerien',
                'en' => 'Algeria'
              ],
              'somalia' => [
                'de' => 'Somalien',
                'en' => 'Somalia'
              ]
            ]
          ]
        ];


        foreach($filters as $key => $f){
          $filter = $this->createFilter($key,$f);
          if(!empty($f['children'])){
            foreach($f['children'] as $k => $c){
              $this->createFilter($k, $c, $filter->id);
            }
          }
        }
    }
}
