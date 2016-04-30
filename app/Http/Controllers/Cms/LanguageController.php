<?php

namespace App\Http\Controllers\Cms;

use App\Http\Requests,
    App\Http\Controllers\Controller;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = \App\Language::all();
        return response()->json($languages);
    }

    public function published()
    {
        $languages = \App\Language::where('disabled', false)
            ->where('published', true)
            ->get();
        return response()->json($languages);
    }
}
