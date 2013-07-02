<?php namespace Shanhaijing\Translation;

use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;

class TranslationServiceProvider extends IlluminateTranslationServiceProvider {

    public function register()
    {
        $this->registerLoader();

        $this->app['translator'] = $this->app->share(function($app)
        {
            $loader = $app['translation.loader'];

            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];

            $trans = new Translator($loader, $locale);

            if (isset($app['config']['app.fallback_locale'])) {
                $trans->setFallbackLocale($app['config']['app.fallback_locale']);
            }

            return $trans;
        });
    }

}

