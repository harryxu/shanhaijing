<?php namespace Shanhaijing\Variable;

use Illuminate\Support\ServiceProvider;

class VariableServiceProvider extends ServiceProvider {
    
    public function register()
    {
        $this->app['variable'] = $this->app->share(function($app)
        {
            return new Variable($app['db']);
        });
    }

}
