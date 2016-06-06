<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth;

class FilterTranslationController extends AbstractTranslationController
{
    public function index()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();
        
        $filters = \App\Filter::all();

        foreach ($filters as $filter) {
            /**
             * @var \App\Filter $filter
             */
            foreach ($activeLanguages as $language) {
                /**
                 * @var \App\Language $language
                 */
                $filter->translate($language->language);
            }
        }

        return response()->success(['filter-translations' => $filters]);
    }

    public function untranslatedIndex()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $untranslated = [];

        $filters = \App\Filter::all();

        foreach ($filters as $idx => $filter) {
            /**
             * @var \App\Filter $filter
             */
            $translatedLanguages = 0;
            $defaultTranslation = $filter->translate($defaultLanguage->language);
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

                $translation = $filter->translate($language->language);
                if ($translation && $translation->version == $version) {
                    $translatedLanguages++;
                }
            }
            if ($translatedLanguages < $activeLanguageCount) {
                $untranslated[] = $filter;
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
        ]);

        $filter = \App\Filter::find((int)$id);
        if (!$filter) {
            return response()->error('Filter not found', 404);
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

        $defaultTranslation = $filter->translate($defaultLanguage->language);
        if (!$defaultTranslation) {
            return response()->error('Language not found', 404);
        }

        $hasChanged = $this->getTranslationService()->hasChanged(
            ($filter->translate($translationLanguage->language) ?
                [
                    'title' =>  $filter->translate($translationLanguage->language)->title,
                    'description' => $filter->translate($translationLanguage->language)->description,
                ] : [
                    'title' => null, 'description' => null,
                ]
            ),
            [
                'title' => $request->get('title'),
                'description' => $request->get('description'),
            ]
        );

        if ($hasChanged) {
            $filter->translateOrNew($translationLanguage->language)->title = $request->get('title');
            $filter->translateOrNew($translationLanguage->language)->description = $request->get('description');
            
            if ($translationLanguage->default_language) {
                $filter->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version + 1;
            } else {
                $filter->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version;
            }
            
            $filter->save();
        }

        return response()->json($filter);
    }
}