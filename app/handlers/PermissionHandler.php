<?php

class PermissionHandler
{

    public function onGetAll($permissions)
    {
        $newPermissions = array_merge($permissions->getArrayCopy(), array(
            'groups.update' => 'Update group',
            'groups.create' => 'Create group',
        ));
        $permissions->exchangeArray($newPermissions);
    }

}
