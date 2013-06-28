<?php

class BaseController extends Controller {

    // current logged in user
    protected $user;

    public function __construct()
    {
        $this->user = Sentry::getUser();
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
}
