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
      $filter->translateOrNew('ar')->title = $f['ar'];
      $filter->translateOrNew('fa')->title = $f['fa'];
      $filter->translateOrNew('fr')->title = $f['fr'];
      $filter->save();
      return $filter;
    }
    public function run()
    {

        $filters = [
          'family' => [
            'de' => 'Familie',
            'en' => 'Families',
            'ar' => 'عوائل',
            'fa' => 'خوانواده‌ها',
            'fr' => 'Famille',
            'type' => 'icon',
            'icon' => '1464870716-Familie'
          ],
          'women' => [
            'de' => 'Frauen',
            'en' => 'Women',
            'ar' => 'نساء',
            'fa' => 'زنان',
            'fr' => 'Femmes',
            'type' => 'icon',
            'icon' => '1464870725-Frauen'

          ],
          'men' => [
            'de' => 'Männer',
            'en' => 'Men',
            'ar' => 'رجال',
            'fa' => 'مردان',
            'fr' => 'Hommes',
            'type' => 'icon',
            'icon' => '1464870734-Maenner'
          ],
          'age' => [
            'de' => 'Alter',
            'en' => 'Age',
            'ar' => 'العمر',
            'fa' => 'سن',
            'fr' => 'Âge',
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              '0-5' => [
                'de' => '0-5 Jahre',
                'en' => '0-5 years',
                'ar' => 'سنة',
                'fa' => '0-5 ساله',
                'fr' => '0-5 ans',
                'icon' => ''
              ],
              '6-10' => [
                'de' => '6-10 Jahre',
                'en' => '6-10 years',
                'ar' => '6-10 سنة',
                'fa' => '6-10 ساله',
                'fr' => '6-10 ans',
                'icon' => ''
              ],
              '11-17' => [
                'de' => '11-17 Jahre',
                'en' => '11-17 years',
                'ar' => '11-17 سنة',
                'fa' => '11-17 ساله',
                'fr' => '11-17 ans',
                'icon' => ''
              ],
              '18-26' => [
                'de' => '18-26 Jahre',
                'en' => '18-26 years',
                'ar' => 'تحت 27',
                'fa' => 'زیر 27 سال',
                'fr' => 'Moins de 27 ans',
                'icon' => ''
              ],
              '27+' => [
                'de' => '27+ Jahre',
                'en' => '27+ years',
                'ar' => '27فوق',
                'fa' => '27+',
                'fr' => 'Plus de 27 ans',
                'icon' => '',
              ]
            ]
          ],
          'persons-with-disabilities' => [
            'de' => 'Menschen mit besonderen Bedürfnissen',
            'en' => 'Persons with Disabilities',
            'ar' => 'الاشخاص ذوى الاحتياجات الخاصة',
            'fa' => 'افراد دارای معلولیت',
            'fr' => 'Personnes handicapées',
            'type' => 'icon',
            'icon' => '1464870455-Barrierefrei'
          ],
          'barrier-free' => [
            'de' => 'Barrierefrei',
            'en' => 'Barrier Free',
            'ar' => 'المقعدين',
            'fa' => 'بدون مانع',
            'fr' => 'Sans barrières',
            'type' => 'icon',
            'icon' => '1464870455-Barrierefrei'
          ],
          'culture-pass' => [
            'de' => 'Kulturpass',
            'en' => 'Culture-pass',
            'ar' => 'تبادل الخضارات',
            'fa' => 'اسپورت فرهنگی',
            'fr' => 'Passe culturel',
            'type' => 'icon',
            'icon' => ''
          ],
          'free' => [
            'de' => 'Gratis',
            'en' => 'Free',
            'ar' => 'مجاناً ',
            'fa' => 'رایگان',
            'fr' => 'Gratuit',
            'type' => 'icon',
            'icon' => '1464870698-Gratis'
          ],
          'lgbtqi' => [
            'de' => 'LGBTQI',
            'en' => 'LGBTQI',
            'ar' => 'المثليين',
            'fa' => 'LGBTQI',
            'fr' => 'LGBT',
            'type' => 'icon',
            'icon' => '1464870705-LGBTQI'
          ],
          'country-of-origin' => [
            'de' => 'Herkunftsland',
            'en' => 'Country of Origin',
            'ar' => 'بلد المنشأ',
            'fa' => 'کشور مبدأ',
            'fr' => "Pays d'origine",
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              'syria' => [
                'de' => 'Syrien',
                'en' => 'Syria',
                'ar' => 'سوريا',
                'fa' => 'سوریه',
                'fr' => 'Syrie',
                'icon' => ''
              ],
              'afghanistan' => [
                'de' => 'Afghanistan',
                'en' => 'Afghanistan',
                'ar' => 'أفغانستان',
                'fa' => 'افغانستان',
                'fr' => 'Afghanistan',
                'icon' => ''
              ],
              'iraq' => [
                'de' => 'Irak',
                'en' => 'Iraq',
                'ar' => 'العراق',
                'fa' => 'عراق',
                'fr' => 'Irak',
                'icon' => ''
              ],
              'iran' => [
                'de' => 'Iran',
                'en' => 'Iran',
                'ar' => 'إيران',
                'fa' => 'ایران',
                'fr' => 'Iran',
                'icon' => ''
              ],
              'pakistan' => [
                'de' => 'Pakistan',
                'en' => 'Pakistan',
                'ar' => 'باكستان',
                'fa' => 'پاکستان',
                'fr' => 'Pakistan',
                'icon' => ''
              ],
              'nigeria' => [
                'de' => 'Nigerien',
                'en' => 'Nigeria',
                'ar' => 'نيجيريا',
                'fa' => 'نیجریه',
                'fr' => 'Niger',
                'icon' => ''
              ],
              'morocco' => [
                'de' => 'Marokko',
                'en' => 'Morocco',
                'ar' => 'المغرب',
                'fa' => 'مراکش',
                'fr' => 'Maroc',
                'icon' => ''
              ],
              'algeria' => [
                'de' => 'Algerien',
                'en' => 'Algeria',
                'ar' => 'الجزائر',
                'fa' => 'الجزایر',
                'fr' => 'Algérie',
                'icon' => ''
              ],
              'somalia' => [
                'de' => 'Somalien',
                'en' => 'Somalia',
                'ar' => 'الصومال',
                'fa' => 'سومالی',
                'fr' => 'Somalie',
                'icon' => ''
              ]
            ]
          ],
          'language-of-service-or-offer' => [
            'de' => 'Sprache des Angebotes',
            'en' => 'Language of service or offer',
            'ar' => 'لغة الخدمة أو العرض',
            'fa' => 'زبان انتخابی برای خدمات یا پیشنهاد',
            'fr' => 'Langues proposées',
            'type' => 'dropdown',
            'icon' => '',
            'children' => [
              'german' => [
                'de' => 'Deutsch',
                'en' => 'German',
                'ar' => 'الألمانية',
                'fa' => 'آلمانی',
                'fr' => 'Allemand',
                'icon' => ''
              ],
              'english' => [
                'de' => 'Englisch',
                'en' => 'English',
                'ar' => 'الأنكليزية',
                'fa' => 'انگلیسی',
                'fr' => 'Anglais',
                'icon' => ''
              ],
              'french' => [
                'de' => 'Französisch',
                'en' => 'French',
                'ar' => 'الفرنسية',
                'fa' => 'فرانسوی',
                'fr' => 'Français',
                'icon' => ''
              ],
              'arabic' => [
                'de' => 'Arabisch',
                'en' => 'Arabic',
                'ar' => 'العربية',
                'fa' => 'عربی',
                'fr' => 'Arabe',
                'icon' => ''
              ],
              'farsi' => [
                'de' => 'Farsi',
                'en' => 'Farsi',
                'ar' => 'الفارسية',
                'fa' => 'فارسی',
                'fr' => 'Farsi',
                'icon' => ''
              ],
              'kurdish' => [
                'de' => 'Kursisch',
                'en' => 'Kurdish',
                'ar' => 'الكردية',
                'fa' => 'کوردی',
                'fr' => 'Kurde',
                'icon' => ''
              ],
              'urdu' => [
                'de' => 'Urdu',
                'en' => 'Urdu',
                'ar' => 'أردو',
                'fa' => 'اردو',
                'fr' => 'Ourdou',
                'icon' => ''
              ],
            ],
          ],
          'status' => [
              'de' => 'Status',
              'en' => 'Status',
              'ar' => 'الحالة',
              'fa' => 'وضعیت',
              'fr' => 'Statut',
              'type' => 'dropdown',
              'icon' => '',
              'children' => [
                'asylum' => [
                  'de' => 'Asyl',
                  'en' => 'Asylum',
                  'ar' => 'Asylum',
                  'fa' => 'پناهندگی',
                  'fr' => 'Asile',
                  'icon' => ''
                ],
                'subsidiary-protection' => [
                  'de' => 'Subsidiärer Schutz',
                  'en' => 'Subsidiary Protection',
                  'ar' => 'الحماية الفرعية',
                  'fa' => 'Subsidiary protection',
                  'fr' => 'Protection subsidiaire',
                  'icon' => ''
                ],
                'ongoing-procedure' => [
                  'de' => 'Subsidiärer Schutz',
                  'en' => 'Ongoing Procedure',
                  'ar' => 'الإجراءات الجارية',
                  'fa' => 'در انتظار',
                  'fr' => 'Procédure en cours',
                  'icon' => ''
                ],
                'umrs' => [
                  'de' => 'UMRs',
                  'en' => 'UMRs',
                  'ar' => 'UMFs',
                  'fa' => 'پناهندگان خردسال بدون همراه',
                  'fr' => 'UMFs',
                  'icon' => ''
                ],
                'unregistered' => [
                  'de' => 'Noch nicht registriert',
                  'en' => 'Unregistered',
                  'ar' => 'غير مسجل',
                  'fa' => 'ثبت نام نکرده',
                  'fr' => 'Non enregistré',
                  'icon' => ''
                ],
                'rejected-asylum-application' => [
                  'de' => 'Negativer Asylbescheid',
                  'en' => 'Rejected Asylum Application',
                  'ar' => 'طلب لجوء مرفوض',
                  'fa' => 'درخواست پناهندگی رد شده',
                  'fr' => "Demande d'asile rejetée",
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
