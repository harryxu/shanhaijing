<?php namespace Shanhaijing\SentryExt\Users\Eloquent;

use Cartalyst\Sentry\Users\Eloquent\Provider as SentryUserProvider;
use Cartalyst\Sentry\Users\UserNotFoundException;

class Provider extends SentryUserProvider {

    protected $model = 'Shanhaijing\Shjsentry\Users\Eloquent\User';

    public function findByEmail($email)
    {
        $model = $this->createModel();

        if (!$user = $model->newQuery()->where('email', '=', $email)->first()) {
            throw new UserNotFoundException("A user could not be found with a email value of [$email].");
        }

        return $user;
    }

    public function findByUsername($username)
    {
        $model = $this->createModel();

        if (!$user = $model->newQuery()->where('username', '=', $username)->first()) {
            throw new UserNotFoundException("A user could not be found with a username value of [$username].");
        }

        return $user;
    }

}
