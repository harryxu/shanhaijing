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
        try {
            // Set login credentials
            $credentials = array(
                'email'    => Input::get('email'),
                'password' => Input::get('password')
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, false);
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

