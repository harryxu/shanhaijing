<?php

class AccountController extends BaseController
{
    public function getRegister()
    {
        return View::make('account/register');
    }

    public function postRegister()
    {
        $user = Sentry::register(array(
            'email'    => Input::get('email'),
            'password' => Input::get('password'),
        ), true);

        return Redirect::to('account/login');
    }

    public function getLogin()
    {
        return View::make('account/login');
    }

    public function postLogin()
    {
        $login = Input::get('login');
        $credentials = array('password' => Input::get('password'));
        if (strpos($login, '@') === false) { // login by username
            $credentials['username'] = $login;
        }
        else { // login by email
            $user = Sentry::getUserProvider()->findByEmail($login);
            $credentials['username'] = $user->username;
        }
        try {
            // Try to authenticate the user
            $user = Input::has('remember')
                ? Sentry::authenticateAndRemember($credentials)
                : Sentry::authenticate($credentials, false);

            return Redirect::intended('/');
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            echo 'User is not activated.';
        }
        catch (Exception $e) {
            return Redirect::to('account/login')
                ->withInput()
                ->with('login_error', true);
        }

    }

    public function getLogout()
    {
        Sentry::logout();
        return Redirect::to('/');
    }
}

