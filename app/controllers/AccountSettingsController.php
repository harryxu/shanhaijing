<?php

class AccountSettingsController extends BaseController
{

    public function getAvatar($user)
    {
        return View::make('account/settings/avatar', array(
            'user' => $user,
        ));
    }

}
