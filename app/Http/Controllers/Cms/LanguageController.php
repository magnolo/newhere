<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request,
    App,
    App\Http\Requests,
    App\Http\Controllers\Controller,
    App\Language;

class LanguageController extends Controller
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
        $languages = Language::all();

        $this->translationService->translateLanguage($languages, App::getLocale());

        return response()->success(compact('languages'));
    }

    public function defaultLanguage()
    {
        $language = \App\Language::where('default_language', true)->first();
        if (!$language) {
            return response()->error('No default language found', 404);
        }

        $this->translationService->translateLanguage($language, App::getLocale());

        return response()->json($language);
    }

    public function enabledIndex()
    {
        $enabled = \App\Language::where('enabled', true)
            ->get();

        $this->translationService->translateLanguage($enabled, App::getLocale());

        return response()->success(compact('enabled'));
    }

    public function publishedIndex()
    {
        $languages = Language::where('enabled', true)
            ->where('published', true)
            ->get();

        $this->translationService->translateLanguage($languages, App::getLocale());

        return response()->json($languages);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'enabled'    => 'boolean',
            'published' => 'boolean',
        ]);

        $language = Language::find((int)$id);
        if (!$language) {
            return response()->error('Language not found', 404);
        }

        $modified = false;
        if (isset($request->enabled)) {
            $language->enabled = (bool)$request->enabled;
            $modified = true;
        }

        if (isset($request->published)) {
            $language->published = (bool)$request->published;
            $modified = true;
        }

        if ($modified) {
            $language->save();
        }

        return response()->success(compact('language'));
    }
}
