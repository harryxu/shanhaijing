<?php

class AdminController extends BaseController {

    public function __construct()
    {
        $this->beforeFilter('login_required');
    }

}

