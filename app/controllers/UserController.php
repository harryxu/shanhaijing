<?php

use Cartalyst\Sentry\Users\UserNotFoundException;

class UserController extends BaseController
{
    public function show($username)
    {
        try {
            $user = Sentry::getUserProvider()->findByUsername($username);
        }
        catch (UserNotFoundException $e) {
            App::abort(404);
        }

        return View::make('user/show', array(
            'user' => $user,
        ));
    }
}

