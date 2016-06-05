<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth;

class CategoryTranslationController extends AbstractTranslationController
{
    public function index()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();

        $categories = \App\Category::all();

        foreach ($categories as $category) {
            /**
             * @var \App\Category $category
             */
            foreach ($activeLanguages as $language) {
                /**
                 * @var \App\Language $language
                 */
                $category->translate($language->language);
            }
        }

        return response()->success(['category-translations' => $categories]);
    }

    public function untranslatedIndex()
    {
        list($activeLanguages, $activeLanguageCount) = $this->loadLanguages();
        $defaultLanguage = \App\Language::where('default_language', true)->first();

        $untranslated = [];

        $categories = \App\Category::all();

        foreach ($categories as $idx => $category) {
            /**
             * @var \App\Category $category
             */
            $translatedLanguages = 0;
            $defaultTranslation = $category->translate($defaultLanguage->language);
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

                $translation = $category->translate($language->language);
                if ($translation && $translation->version == $version) {
                    $translatedLanguages++;
                }
            }
            if ($translatedLanguages < $activeLanguageCount) {
                $untranslated[] = $category;
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

        $category = \App\Category::find((int)$id);
        if (!$category) {
            return response()->error('Category not found', 404);
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

        $defaultTranslation = $category->translate($defaultLanguage->language);
        if (!$defaultTranslation) {
            return response()->error('Language not found', 404);
        }

        $hasChanged = $this->getTranslationService()->hasChanged(
            ($category->translate($translationLanguage->language) ?
                [
                    'title' =>  $category->translate($translationLanguage->language)->title,
                    'description' => $category->translate($translationLanguage->language)->description,
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
            $category->translateOrNew($translationLanguage->language)->title = $request->get('title');
            $category->translateOrNew($translationLanguage->language)->description = $request->get('description');
            if ($translationLanguage->default_language) {
                $category->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version + 1;
            } else {
                $category->translateOrNew($translationLanguage->language)->version = $defaultTranslation->version;
            }
            $category->save();
        }

        return response()->json($category);
    }
}
