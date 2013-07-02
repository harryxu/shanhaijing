<?php namespace Shanhaijing\Translation;

use Illuminate\Translation\Translator as IlluminateTranslator;

class Translator extends IlluminateTranslator {

    protected $fallback_locale = null;

    public function get($key, array $replace = array(), $locale = null)
    {
        list($namespace, $group, $item) = $this->parseKey($key);

        // Here we will get the locale that should be used for the language line. If one
        // was not passed, we will use the default locales which was given to us when
        // the translator was instantiated. Then, we can load the lines and return.
        $locale = $locale ?: $this->getLocale();

        $this->load($namespace, $group, $locale);

        $line = $this->getLine(
            $namespace, $group, $locale, $item, $replace
        );

        // If the line doesn't exist, we will try to get the line from fallback locale.
        // And if still not exist, we will return back the key which was requested as
        // that will be quick to spot in the UI if language keys are wrong or missing
        // from the application's language files. Otherwise we can return the line.
        if (is_null($line)) {
            $fallback_locale = $this->getFallbackLocale();
            if (!is_null($fallback_locale) && $locale != $fallback_locale) {
                return $this->get($key, $replace, $fallback_locale);
            }
            else {
                return $key;
            }
        }

        return $line;

    }

    public function getFallbackLocale()
    {
        return $this->fallback_locale;
    }

    public function setFallbackLocale($locale)
    {
        $this->fallback_locale = $locale;
    }


}
