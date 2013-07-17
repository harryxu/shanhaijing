<?php

use Shanhaijing\SentryExt\Users\Eloquent\User;

class AccountSettingsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $username = Route::getCurrentRoute()->getParameter('username');
        $user = Sentry::getUserProvider()->findByUsername($username);
        if (!$user) {
            App::abort(404);
        }
        if (!Sentry::check() || $this->user->id != $user->id) {
            App::abort(403);
        }
        View::share('user', $user);
    }

    public function getAvatar()
    {
        return View::make('account/settings/avatar');
    }

}
