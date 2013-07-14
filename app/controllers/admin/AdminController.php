<?php

use Stevemo\Cpanel\Controllers\BaseController as CpanelBaseController;

class AdminController extends CpanelBaseController {

    public function __construct()
    {
        $this->beforeFilter('login_required');
    }

}

