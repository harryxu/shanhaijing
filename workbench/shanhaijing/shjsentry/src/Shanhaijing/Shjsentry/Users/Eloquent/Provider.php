<?php namespace Shanhaijing\Shjsentry\Users\Eloquent;

use Cartalyst\Sentry\Users\Eloquent\Provider as SentryUserProvider;
use Cartalyst\Sentry\Users\UserNotFoundException;

class Provider extends SentryUserProvider {

    public function findByEmail($email)
    {
        $model = $this->createModel();

        if (!$user = $model->newQuery()->where('email', '=', $email)->first()) {
            throw new UserNotFoundException("A user could not be found with a email value of [$email].");
        }

        return $user;
    }

}
