<?php

class PermissionHandler
{

    public function onGetAll($permissions)
    {
        $newPermissions = array_merge($permissions->getArrayCopy(), array(
            'admin.view' => 'Access admin area',

            // users
            'users.view' => 'View users', 
            'users.create' => 'Create new user', 
            'users.update' => 'Update exist user', 
            'users.delete' => 'Delete user',

            // groups
            'groups.view' => 'View groups', 
            'groups.create' => 'Create new group', 
            'groups.update' => 'Update exist group', 
            'groups.delete' => 'Delete group',
        ));
        $permissions->exchangeArray($newPermissions);
    }

}
