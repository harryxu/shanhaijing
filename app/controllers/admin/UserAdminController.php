<?php

use Shanhaijing\Shjsentry\Users\Eloquent\User;

/**
 * Class UserAdminController 
 * @author harryxu
 */
class UserAdminController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $users = User::all();
        return View::make('admin/user/index', array(
            'users' => $users,
        ));
    }

    public function permissions($user)
    {
        if (Input::getMethod() == 'POST') {
            $permissions = json_decode(Input::get('permissions'));
            $user->permissions = (array)$permissions;
            $user->save();
            return Redirect::refresh();
        }
        return View::make('admin/user/permission', array(
            'permissions' => json_encode($user->getPermissions()),
            'user' => $user,
        ));
    }
    
}

