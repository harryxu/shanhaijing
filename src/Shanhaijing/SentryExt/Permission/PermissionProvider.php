<?php namespace Shanhaijing\SentryExt\Permission;

use Illuminate\Support\Facades\Event;

class PermissionProvider implements PermissionProviderInterface
{
    public function all()
    {
        $permissions = new \ArrayObject();
        Event::fire('permissions.all', array($permissions));
        return $permissions;
    }
}
