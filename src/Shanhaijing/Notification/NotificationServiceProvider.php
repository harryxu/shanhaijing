<?php namespace Shanhaijing\Notification;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class NotificationServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app['notification'] = $this->app->share(function($app)
        {
            return new Provider();
        });
    }

}
