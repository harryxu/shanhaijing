<?php

use Shanhaijing\SentryExt\Permission\PermissionProviderInterface;

class UsersPermissionsController extends AdminController
{
    protected $permissionProvider;

    public function __construct(PermissionProviderInterface $permissionProvider)
    {
        parent::__construct();
        $this->permissionProvider = $permissionProvider;
    }

    public function index($user)
    {
        $allPermissions = $this->permissionProvider->all()->getArrayCopy();
        $allPermissions = array_flip($allPermissions);
        foreach ($allPermissions as $desc => $perm) {
            $allPermissions[$desc] = "rules[$perm]";
        }

        $_userPermissions = $user->permissions;
        $userPermissions = array();
        foreach ($_userPermissions as $perm => $value) {
            $userPermissions["rules[$perm]"] = true;
        }

        return View::make('admin/user/permission', array(
            'userPermissions' => $userPermissions,
            'allPermissions' => $allPermissions,
            'user' => $user,
        ));
    }

    public function update($user)
    {
        $rules = Input::get('rules');
        $user->permissions = $rules;
        $user->save();
        return Redirect::back()
            ->with('success', Lang::get('cpanel::users.update_success'));
    }
}

