<?php

use Cartalyst\Sentry\Users\UserNotFoundException;

class UserController extends BaseController
{
    public function show($username)
    {
        return View::make('user/show', array(
            'user' => $this->getUser($username),
        ));
    }

    public function starred($username)
    {
        $user = $this->getUser($username);
        $this->currentUserRequired($user);
        $topicUsers = TopicUser::where('user_id', $user->id)
            ->where('starred', true)
            ->orderBy('starred_at', 'DESC')
            ->get(array('topic_id'));
        $topics = array();
        foreach ($topicUsers as $tu) {
            $topics[] = Topic::find($tu->topic_id);
        }
        return View::make('user/starred', array(
            'user' => $user,
            'topics' => $topics,
        ));
    }

    protected function getUser($username) 
    {
        try {
            $user = Sentry::getUserProvider()->findByUsername($username);
            return $user;
        }
        catch (UserNotFoundException $e) {
            App::abort(404);
        }
    }

    /**
     * Check the user is current logged in user.
     *
     * TODO Maybe create a route filter for this?
     */
    protected function currentUserRequired($user)
    {
        if (!(Sentry::check() && $this->user->id == $user->id)) {
            App::abort(403);
        }
    }
}

