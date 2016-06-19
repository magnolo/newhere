<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth,
    App;

class OfferTranslationController extends AbstractTranslationController
{
    /**
     * @var \App\Services\Translation
     */
    private $translationService;

    public function __construct(\App\Services\Translation $translationService){
        $this->translationService = $translationService;

        App::setLocale(app('request')->header('language'));
    }
    
    public function index()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();

        /**
         * @todo check for verified offers
         */
        $offers = \App\Offer::all();

        foreach ($offers as $offer) {
            /**
             * @var \App\Offer $offer
             */
            foreach ($activeLanguages as $language) {
                /**
                 * @var \App\Language $language
                 */
                $offer->translate($language->language);
            }
        }

        return response()->success(['offer-translations' => $offers]);
    }

    public function untranslatedIndex()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $untranslated = [];

        /**
         * @todo check for verified offers
         */
        $offers = \App\Offer::all();

        foreach ($offers as $idx => $offer) {
            /**
             * @var \App\Offer $offer
             */
            $translatedLanguages = 0;
            $defaultTranslation = $offer->translate($defaultLanguage->language);
            if (!$defaultTranslation) {
                unset($offers[$idx]);
                continue;
                //return response()->error('Default translation not found', 404);
            }
            $version = $defaultTranslation->version;

            foreach ($activeLanguages as $language) {
                /**
                 * @var \App\Language $language
                 */
                if ($language->default_language) {
                    continue;
                }

                $translation = $offer->translate($language->language);
                if ($translation && $translation->version == $version) {
                    $translatedLanguages++;
                }
            }
            if ($translatedLanguages < $activeLanguageCount) {
                $untranslated[] = $offer;
            }
        }

        return response()->success(compact('untranslated'));
    }

    public function translate(Request $request, $id)
    {
        $this->validate($request, [
            'language' => 'required|min:2|max:2',
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:10000',
            'opening_hours' => 'string|max:10000',
        ]);

        $offer = \App\Offer::find((int)$id);
        if (!$offer) {
            return response()->error('Offer not found', 404);
        }

        $defaultLanguage = \App\Language::where('default_language', true)->first();
        if (!$defaultLanguage) {
            return response()->error('Default language not found', 404);
        }

        $translationLanguage = \App\Language::where('language', $request->get('language'))->first();
        if (!$translationLanguage) {
            return response()->error('Language not found', 404);
        }
        if (!$translationLanguage->enabled) {
            return response()->error('Language not enabled', 404);
        }

        $defaultTranslation = $offer->translate($defaultLanguage->language);
        if (!$defaultTranslation) {
            return response()->error('Language not found', 404);
        }

        $hasChanged = $this->getTranslationService()->hasChanged(
            ($offer->translate($translationLanguage->language) ?
                [
                    'title' => $offer->translate($translationLanguage->language)->title,
                    'description' => $offer->translate($translationLanguage->language)->description,
                    'opening_hours' => $offer->translate($translationLanguage->language)->opening_hours,
                ] : [
                    'title' => null, 'description' => null, 'opening_hours' => null,
                ]
            ),
            [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'opening_hours' => $request->get('opening_hours'),
            ]
        );

        if ($hasChanged) {
            $offer->translateOrNew($translationLanguage->language)->title = $request->get('title');
            $offer->translateOrNew($translationLanguage->language)->description = $request->get('description');
            $offer->translateOrNew($translationLanguage->language)->opening_hours = $request->get('opening_hours');
            if ($translationLanguage->default_language) {
                $offer->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version + 1;
            } else {
                $offer->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version;
            }
            $offer->save();
        }

        return response()->json($offer);
    }

    public function stats()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();

        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $offers = \App\Offer::all();
        $stats = [];

        foreach ($offers as $idx => $offer) {
            /**
             * @var \App\Offer $offer
             */
            $defaultTranslation = $offer->translate($defaultLanguage->language);
            if (!$defaultTranslation) {
                unset($offers[$idx]);
                continue;
            }
            $version = $defaultTranslation->version;

            foreach ($activeLanguages as $language) {
                /**
                 * @var \App\Language $language
                 */
                if ($language->default_language) {
                    continue;
                }
                
                if (!isset($stats[$language->language])) {
                    $this->translationService->translateLanguage($language, App::getLocale());
                    $stats[$language->language]['language'] = $language;
                    $stats[$language->language]['translated'] = 0;
                    $stats[$language->language]['untranslated'] = 0;
                }   

                $translation = $offer->translate($language->language);
                if ($translation && $translation->version == $version) {
                    $stats[$language->language]['translated']++;
                } else {
                    $stats[$language->language]['untranslated']++;
                }
            }
        }

        return response()->success([
            'stats' => $stats
        ]);
    }
}
