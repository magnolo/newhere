<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth;

class OfferTranslationController extends Controller
{
    /**
     * @var \App\Services\Translation
     */
    private $translationService;

    public function __construct(\App\Services\Translation $translationService)
    {
        $this->translationService = $translationService;
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

        $hasChanged = $this->translationService->hasChanged(
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

    private function loadLanguages()
    {
        /**
         * @var \App\User $user
         */
        $user = Auth::user();
        $user->load('roles');

        $allLanguages = true;

        foreach ($user->roles as $role) {
            if (in_array($role->name, ['moderator'])) {
                $allLanguages = false;
                break;
            }
        }

        $decreaseCount = 0;
        if ($allLanguages) {
            $languages = \App\Language::where('enabled', true)->get();
            $decreaseCount = 1;
        } else {
            $languages = $user->languages()->get();
            foreach ($languages as $language) {
                if ($language->default_language) {
                    $decreaseCount = 1;
                    break;
                }
            }
        }

        return [
            $languages,
            $languages->count() - $decreaseCount
        ];
    }
}
