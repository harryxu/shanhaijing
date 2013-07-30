<?php namespace Shanhaijing\Lock;

use Illuminate\Support\ServiceProvider;

class LockServiceProvider extends ServiceProvider {
    
    public function register()
    {
        $this->app->singleton('lock', function($app)
        {
            return new DBStoreLock($app['db']);
        });
    }

}
