<?php

class AccountController extends BaseController
{
    public function getRegister()
    {
        return View::make('account/register');
    }

    public function postRegister()
    {
        $validator = Validator::make(Input::all(), array(
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ));

        if ($validator->fails()) {
            return Redirect::to('account/register')->withErrors($validator)->withInput();
        }

        $user = Sentry::register(array(
            'email'    => Input::get('email'),
            'username' => Input::get('username'),
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
        $validator = Validator::make(Input::all(), array(
            'login' => 'required',
            'password' => 'required',
        ));
        if ($validator->fails()) {
            return Redirect::to('account/login')->withErrors($validator)->withInput();
        }

        try {
            $login = Input::get('login');
            $credentials = array('password' => Input::get('password'));
            if (strpos($login, '@') === false) { // login by username
                $credentials['username'] = $login;
            }
            else { // login by email
                $user = Sentry::getUserProvider()->findByEmail($login);
                $credentials['username'] = $user->username;
            }
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

