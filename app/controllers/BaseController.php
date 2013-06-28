<?php

class BaseController extends Controller {

    // current logged in user
    protected $user;

    public function __construct()
    {
        $this->user = Sentry::getUser();

        View::share('notifications', $this->getNotifications());
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

    protected function getNotifications()
    {
        $notifincations = array();
        if (Sentry::check()) {
            $user = Sentry::getUser();

            $notifincations = Notification::where('user_id', $user->id)
                ->where('readed', 0)
                ->get();
        }

        return $notifincations;
    }

}
