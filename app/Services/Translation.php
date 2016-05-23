<?php
namespace App\Services;

class Translation
{
    public function hasChanged(array $current, array $new)
    {
        return (bool)array_diff($new, $current);
    }

    public function translateLanguage($data, $locale)
    {
        if ($data instanceof \App\Language) {
            $data->i18n = \Locale::getDisplayLanguage($data->language, $locale);
        } else {
            foreach ($data as $d) {
                $this->translateLanguage($d, $locale);
            }
        }
    }
}