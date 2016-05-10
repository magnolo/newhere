<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller;

class OfferTranslationController extends Controller
{
    public function index()
    {
        $offers = \App\Offer::whereNull('deleted')->get();

        $activeLanguages = \App\Language::where('enabled', true)->get();

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

        return response()->json($offers);
    }

    public function untranslatedIndex()
    {
        $offers = \App\Offer::whereNull('deleted')->get();

        /**
         * @todo: if translator is logged in, check only his language(s)
         */
        $activeLanguages = \App\Language::where('enabled', true)->get();
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $untranslatedOffers = [];

        $activeLanguageCount = $activeLanguages->count() - 1;

        foreach ($offers as $idx => $offer) {
            /**
             * @var \App\Offer $offer
             */
            $translatedLanguages = 0;
            $defaultTranslation = $offer->translate($defaultLanguage->language);
            if (!$defaultTranslation) {
                return response()->error('Default translation not found', 404);
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
                $untranslatedOffers[] = $offer;
            }
        }

        return response()->json($untranslatedOffers);
    }

    public function translate(Request $request, $id)
    {
        $this->validate($request, [
            'language' => 'required|min:2|max:2',
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:10000',
            'opening_hours' => 'string|max:10000'
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

        if ($translationLanguage->default_language) {
            $defaultTranslation->title = $request->get('title');
            $defaultTranslation->description = $request->get('description');
            $defaultTranslation->opening_hours = $request->get('opening_hours');
            $defaultTranslation->version = $defaultTranslation->version + 1;
        } else {
            $offer->translateOrNew($translationLanguage->language)->title = $request->get('title');
            $offer->translateOrNew($translationLanguage->language)->description = $request->get('description');
            $offer->translateOrNew($translationLanguage->language)->opening_hours = $request->get('opening_hours');
            $offer->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version;
        }
        $offer->save();

        return response()->json($offer);
    }
}
