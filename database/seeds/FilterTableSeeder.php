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
      $filter->icon = $f['icon'];
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
            'type' => 'icon',
            'icon' => 'family'
          ],
          'women' => [
            'de' => 'Frauen',
            'en' => 'Women',
            'type' => 'icon',
            'icon' => 'woman'

          ],
          'men' => [
            'de' => 'Männer',
            'en' => 'Men',
            'type' => 'icon',
            'icon' => 'man'
          ],
          'age' => [
            'de' => 'Alter',
            'en' => 'Age',
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              '0-5' => [
                'de' => '0-5 Jahre',
                'en' => '0-5 years',
                'icon' => ''
              ],
              '5-10' => [
                'de' => '5-10 Jahre',
                'en' => '5-10 years',
                'icon' => ''
              ],
              '11-17' => [
                'de' => '11-17 Jahre',
                'en' => '11-17 years',
                'icon' => ''
              ],
              'under-27' => [
                'de' => 'unter 27',
                'en' => 'under 27',
                'icon' => ''
              ],
              '27+' => [
                'de' => '27+',
                'en' => '27+',
                'icon' => ''
              ]
            ]
          ],
          'persons-with-disabilities' => [
            'de' => 'Menschen mit besonderen Bedürfnissen',
            'en' => 'Persons with Disabilities',
            'type' => 'icon',
            'icon' => 'handicaped'
          ],
          'barrier-free' => [
            'de' => 'Barrierefrei',
            'en' => 'Barrier Free',
            'type' => 'icon',
            'icon' => 'handicaped'
          ],
          'culture-pass' => [
            'de' => 'Kulturpass',
            'en' => 'Culture Pass',
            'type' => 'icon',
            'icon' => 'culture'
          ],
          'free' => [
            'de' => 'Gratis',
            'en' => 'Free',
            'type' => 'icon',
            'icon' => 'free'
          ],
          'country-of-origin' => [
            'de' => 'Herkunftsland',
            'en' => 'Country of Origin',
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              'syria' => [
                'de' => 'Syrien',
                'en' => 'Syria',
                'icon' => ''
              ],
              'afghanistan' => [
                'de' => 'Afghanistan',
                'en' => 'Afghanistan',
                'icon' => ''
              ],
              'iraq' => [
                'de' => 'Irak',
                'en' => 'Iraq',
                'icon' => ''
              ],
              'iran' => [
                'de' => 'Iran',
                'en' => 'Iran',
                'icon' => ''
              ],
              'pakistan' => [
                'de' => 'Pakistan',
                'en' => 'Pakistan',
                'icon' => ''
              ],
              'nigeria' => [
                'de' => 'Nigerien',
                'en' => 'Nigeria',
                'icon' => ''
              ],
              'morocco' => [
                'de' => 'Marokko',
                'en' => 'Morocco',
                'icon' => ''
              ],
              'algeria' => [
                'de' => 'Algerien',
                'en' => 'Algeria',
                'icon' => ''
              ],
              'somalia' => [
                'de' => 'Somalien',
                'en' => 'Somalia',
                'icon' => ''
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
