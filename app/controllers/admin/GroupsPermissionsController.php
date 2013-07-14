<?php

use Shanhaijing\SentryExt\Permission\PermissionProviderInterface;

class GroupsPermissionsController extends AdminController
{
    protected $permissionProvider;

    public function __construct(PermissionProviderInterface $permissionProvider)
    {
        parent::__construct();
        $this->permissionProvider = $permissionProvider;
    }

    public function index($group)
    {
        $allPermissions = $this->permissionProvider->all()->getArrayCopy();
        $allPermissions = array_flip($allPermissions);
        foreach ($allPermissions as $desc => $perm) {
            $allPermissions[$desc] = "rules[$perm]";
        }

        $_gruopPermission = $group->permissions;
        $groupPermissions = array();
        foreach ($_gruopPermission as $perm => $value) {
            $groupPermissions["rules[$perm]"] = true;
        }

        return View::make('admin/group/permission', array(
            'groupPermissions' => $groupPermissions,
            'allPermissions' => $allPermissions,
            'group' => $group,
        ));
    }

    public function update($group)
    {
        $rules = Input::get('rules');
        $group->permissions = $rules;
        $group->save();
        return Redirect::back()
            ->with('success', Lang::get('cpanel::groups.update_success'));
    }
}

