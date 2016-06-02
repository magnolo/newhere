<?php

use Illuminate\Database\Seeder;

use App\Filter;
use App\Image;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function createFilter($key, $f, $parent_id = null){
      $filter = new Filter();
      $filter->slug = $key;

      $filter->parent_id = $parent_id;
      $filter->type = isset($f['type']) ? $f['type'] : null;

      if($f['icon']){
        $icon = Image::where('basename', 'like', '%'.$f['icon']."%" )->first();
        $filter->image_id = $icon->id;
      }

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
            'en' => 'Families',
            'type' => 'icon',
            'icon' => '1464870716-Familie'
          ],
          'women' => [
            'de' => 'Frauen',
            'en' => 'Women',
            'type' => 'icon',
            'icon' => '1464870725-Frauen'

          ],
          'men' => [
            'de' => 'Männer',
            'en' => 'Men',
            'type' => 'icon',
            'icon' => '1464870734-Maenner'
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
              '6-10' => [
                'de' => '6-10 Jahre',
                'en' => '6-10 years',
                'icon' => ''
              ],
              '11-17' => [
                'de' => '11-17 Jahre',
                'en' => '11-17 years',
                'icon' => ''
              ],
              '18-26' => [
                'de' => '18-26 Jahre',
                'en' => '18-26 years',
                'icon' => ''
              ],
              '27+' => [
                'de' => '27+ Jahre',
                'en' => '27+ years',
                'icon' => ''
              ]
            ]
          ],
          'persons-with-disabilities' => [
            'de' => 'Menschen mit besonderen Bedürfnissen',
            'en' => 'Persons with Disabilities',
            'type' => 'icon',
            'icon' => '1464870455-Barrierefrei'
          ],
          'barrier-free' => [
            'de' => 'Barrierefrei',
            'en' => 'Barrier Free',
            'type' => 'icon',
            'icon' => '1464870455-Barrierefrei'
          ],
          'culture-pass' => [
            'de' => 'Kulturpass',
            'en' => 'Culture-pass',
            'type' => 'icon',
            'icon' => ''
          ],
          'free' => [
            'de' => 'Gratis',
            'en' => 'Free',
            'type' => 'icon',
            'icon' => '1464870698-Gratis'
          ],
          'lgbtqi' => [
            'de' => 'LGBTQI',
            'en' => 'LGBTQI',
            'type' => 'icon',
            'icon' => '1464870705-LGBTQI'
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
          ],
          'language-of-service-or-offer' => [
            'de' => 'Sprache des Angebotes',
            'en' => 'Language of service or offer',
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              'german' => [
                'de' => 'Deutsch',
                'en' => 'German',
                'icon' => ''
              ],
              'english' => [
                'de' => 'Englisch',
                'en' => 'English',
                'icon' => ''
              ],
              'french' => [
                'de' => 'Französisch',
                'en' => 'French',
                'icon' => ''
              ],
              'arabic' => [
                'de' => 'Arabisch',
                'en' => 'Arabic',
                'icon' => ''
              ],
              'farsi' => [
                'de' => 'Farsi',
                'en' => 'Farsi',
                'icon' => ''
              ],
              'kurdish' => [
                'de' => 'Kursisch',
                'en' => 'Kurdish',
                'icon' => ''
              ],
              'urdu' => [
                'de' => 'Urdu',
                'en' => 'Urdu',
                'icon' => ''
              ],
            ],
          ],
          'status' => [
              'de' => 'Status',
              'en' => 'Status',
              'type' => 'dropdown',
              'icon' => '',
              'children' => [
                'asylum' => [
                  'de' => 'Asyl',
                  'en' => 'Asylum',
                  'icon' => ''
                ],
                'subsidiary-protection' => [
                  'de' => 'Subsidiärer Schutz',
                  'en' => 'Subsidiary Protection',
                  'icon' => ''
                ],
                'ongoing-procedure' => [
                  'de' => 'Subsidiärer Schutz',
                  'en' => 'Ongoing Procedure',
                  'icon' => ''
                ],
                'umrs' => [
                  'de' => 'UMRs',
                  'en' => 'UMRs',
                  'icon' => ''
                ],
                'unregistered' => [
                  'de' => 'Noch nicht registriert',
                  'en' => 'Unregistered',
                  'icon' => ''
                ],
                'rejected-asylum-application' => [
                  'de' => 'Negativer Asylbescheid',
                  'en' => 'Rejected Asylum Application',
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
