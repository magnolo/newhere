<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth;

class NgoTranslationController extends Controller
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
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $allNgos = \App\Ngo::all();

        foreach ($allNgos as $idx => $ngo) {

            // filter NGOs that have no description (description is an optional field in NGO)
            $defaultTranslation = $ngo->translate($defaultLanguage->language);
            if (!$defaultTranslation) {
                unset($allNgos[$idx]);
                continue;
            } else {
                /**
                 * @var \App\Ngo $ngo
                 */
                foreach ($activeLanguages as $language) {
                    /**
                     * @var \App\Language $language
                     */
                    $ngo->translate($language->language);

                }
            }
        }

        return response()->success(['ngo-translations' => $allNgos]);
    }

    public function untranslatedIndex()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $untranslated = [];

        $ngos = \App\Ngo::all();

        foreach ($ngos as $idx => $ngo) {
            /**
             * @var \App\Ngo $ngo
             */
            $translatedLanguages = 0;
            $defaultTranslation = $ngo->translate($defaultLanguage->language);
            if (!$defaultTranslation) {
                unset($ngos[$idx]);
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

                $translation = $ngo->translate($language->language);
                if ($translation && $translation->version == $version) {
                    $translatedLanguages++;
                }
            }
            if ($translatedLanguages < $activeLanguageCount) {
                $untranslated[] = $ngo;
            }
        }

        return response()->success(compact('untranslated'));
    }

    public function translate(Request $request, $id)
    {
        $this->validate($request, [
            'language' => 'required|min:2|max:2',
            'description' => 'required|string|min:1|max:10000',
        ]);

        $ngo = \App\Ngo::find((int)$id);
        if (!$ngo) {
            return response()->error('Ngo not found', 404);
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

        $defaultTranslation = $ngo->translate($defaultLanguage->language);
        if (!$defaultTranslation) {
            return response()->error('Language not found', 404);
        }

        $hasChanged = $this->translationService->hasChanged(
            ($ngo->translate($translationLanguage->language) ?
                [
                    'description' => $ngo->translate($translationLanguage->language)->description,
                ] : [
                    'description' => null,
                ]
            ),
            [
                'description' => $request->get('description'),
            ]
        );

        if ($hasChanged) {
            $ngo->translateOrNew($translationLanguage->language)->description = $request->get('description');
            if ($translationLanguage->default_language) {
                $ngo->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version + 1;
            } else {
                $ngo->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version;
            }
            $ngo->save();
        }

        return response()->json($ngo);
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
