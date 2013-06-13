<?php namespace Shanhaijing\Shjsentry;

use Shanhaijing\Shjsentry\Users\Eloquent\Provider as UserProvider;
use Cartalyst\Sentry\SentryServiceProvider;

class ShjsentryServiceProvider extends SentryServiceProvider {

    protected function registerUserProvider()
    {
        $this->app['sentry.user'] = $this->app->share(function($app)
        {
            $model = $app['config']['cartalyst/sentry::users.model'];

            // We will never be accessing a user in Sentry without accessing
            // the user provider first. So, we can lazily setup our user
            // model's login attribute here. If you are manually using the
            // attribute outside of Sentry, you will need to ensure you are
            // overriding at runtime.
            if (method_exists($model, 'setLoginAttribute'))
            {
                $loginAttribute = $app['config']['cartalyst/sentry::users.login_attribute'];

                forward_static_call_array(
                    array($model, 'setLoginAttribute'),
                    array($loginAttribute)
                );
            }

            return new UserProvider($app['sentry.hasher'], $model);
        });
    }

}
