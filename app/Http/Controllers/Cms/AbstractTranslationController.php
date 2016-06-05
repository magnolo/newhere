<?php

namespace App\Http\Controllers\Cms;

use App\Http\Requests,
    App\Http\Controllers\Controller,
    Auth;

abstract class AbstractTranslationController extends Controller
{
    /**
     * @var \App\Services\Translation
     */
    private $translationService;

    public function __construct(\App\Services\Translation $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * @return \App\Services\Translation
     */
    protected function getTranslationService()
    {
        return $this->translationService;
    }

    protected function loadLanguages()
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
